<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } else {
        $previousUrl = 'home.php';
    }
    $userId = $_SESSION['id'];
    $room_id = $_GET['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE room_id = ? ');
    $stmt->bind_param('i', $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $topic_id = $rows['topic_id'];

    $stmt = $conn->prepare(' SELECT * FROM tbl_student WHERE id = ? ');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $img_url = $rows['img_url'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>ICT Study-Buddy</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../bootstrap/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.png">
    </head>

    <body onload="loaderFunction()">
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top px-2">
                <h4 class="d-flex align-items-center justify-content-center fw-bolder mt-2">
                    <a href="test.php?id=<?php echo $topic_id; ?>"><i class="bx bx-chevron-left fs-1"></i></a>
                    <span class="pb-1">&nbsp;Challenge Mode Test</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <?php
            $room_id = $_GET['id'];

            $stmt = $conn->prepare('SELECT * FROM tbl_invite_practice WHERE room_id = ?');
            $stmt->bind_param('i', $room_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $invite_from = $row['invite_from'];
            $invite_to = $row['invite_to'];
            $topic_id = $row['topic_id'];

            $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE room_id = ? ');
            $stmt->bind_param('i', $room_id);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $student_answer = $row['student_answer'];
                $student_id = $row['student_id'];
                if ((!empty($student_answer)) && ($student_id === $_SESSION['id'])) {
                    echo '
                        <script>
                            document.getElementById("doneChallenge").style.display = "block";
                        </script>';
                } else {
                    echo "
                        <section class='background-waiting' id='doneChallenge' style='display:none;'>
                            <section class='waiting'>
                                <p>You're already done with this challenge.</p>
                            </section>
                        </section>";
                }
            }

            $stmt = $conn->prepare('SELECT * FROM tbl_invite_practice WHERE room_id = ?');
            $stmt->bind_param('i', $room_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if ($row['invite_status_id'] === 2) {
                echo '
                    <script>
                        function loaderFunction() {
                            document.getElementById("backgroundWaiting").style.display = "block";
                            setTimeout(hideBackgroundWaiting, 3000);
                        }
                        function hideBackgroundWaiting() {
                            location.href = "practice-duo.php?id=' . $room_id . '";
                        }
                        window.onload = loaderFunction;
                    </script>';
            }
            ?>
            <section class="background-waiting" id="backgroundWaiting" style="display: none;">
                <section class="waiting">
                    <p>Waiting for opponent...</p>
                </section>
            </section>
            <div class="container practice mt-5 mb-3">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="../../backend/practice-duo-submit.php?id=<?php echo $room_id ?>" method="POST">
                            <?php
                            $stmt = $conn->prepare(' SELECT 
                            tbl_sub_topics.topic_id,
                            tbl_topics.topic_title
                            FROM tbl_sub_topics 
                            INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                            WHERE tbl_sub_topics.topic_id = ? ');
                            $stmt->bind_param('i', $topic_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            echo '
                                <h5 class="fw-bold mb-5 mt-3 ">Topic: ' . $rows['topic_title'] . ' </h5>
                            ';

                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE topic_id = ? AND student_id = ? ');
                            $stmt->bind_param('ii', $topic_id, $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (mysqli_num_rows($result) > 0) {
                            } else {
                            }

                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
                            $stmt->bind_param('i', $topic_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows_array = array();
                            while ($row = $result->fetch_assoc()) {
                                $rows_array[] = $row;
                            }
                            shuffle($rows_array);
                            foreach ($rows_array as $rows) {
                                $item_number = $rows['item_number'];
                                $question = $rows['question'];
                                $choices = array(
                                    $rows['choice1'],
                                    $rows['choice2'],
                                    $rows['choice3'],
                                    $rows['choice4']
                                );
                                shuffle($choices);
                                echo '
                                    <h6>' . $question . '</h6>
                                    <fieldset class="row mb-4 mt-3">
                                ';
                                foreach ($choices as $index => $choice) {
                                    echo '
                                    <div class="col-sm-10">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option' . ($index + 1) . '_' . $item_number . '" value="' . $choice . '" required>
                                            <label class="form-check-label" for="option' . ($index + 1) . '_' . $item_number . '">
                                                ' . $choice . '
                                            </label>
                                        </div>
                                    </div>
                                ';
                                }
                                echo '</fieldset>';
                            }
                            ?>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <button class="btn-reset w-50 d-flex align-items-center justify-content-center p-2" type="reset">
                                    Reset
                                </button>&nbsp; &nbsp;
                                <button class="btn-login w-50 d-flex align-items-center justify-content-center p-2" type="submit">
                                    <span id="submit">Submit</span>
                                    <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="d-flex align-items-center justify-content-between fixed-bottom px-5">
                <a href="home.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-home-alt fs-3 fw-bolder"></i>
                    <span class="fw-bold">Home</span>
                </a>
                <a href="#" class="d-flex flex-column align-items-center mt-2" style="color: #3552a1;">
                    <i class="bx bxs-collection fs-3 fw-bolder"></i>
                    <span class="fw-bold">Topics</span>
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-pencil fs-3 fw-bolder"></i>
                    <span class="fw-bold">Quiz</span>
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-bell fs-3 fw-bolder"></i>
                    <span class="fw-bold">Notifications
                        <?php
                        $notifications = 0;
                        $invite_status_id = 2;
                        $stmt = $conn->prepare(' SELECT * FROM tbl_invite_practice WHERE invite_to = ? AND invite_status_id = ?');
                        $stmt->bind_param('ii', $_SESSION['id'], $invite_status_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = $result->fetch_assoc();
                        $notifications = $notifications + mysqli_num_rows($result);
                        echo '
                                <span class="notifications" id="notifications">' . $notifications . '</span>
                            ';
                        if ($notifications === 0) {
                            echo '
                                <script>
                                    document.getElementById("notifications").style.display = "none";
                                </script>
                            ';
                        } else {
                            echo '
                                <script>
                                    document.getElementById("notifications").style.display = "flex";
                                </script>
                            ';
                        }
                        ?>
                    </span>
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>
        <script>
            function goBack() {
                window.location.href = "<?php echo $previousUrl; ?>";
            }
        </script>

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
}
