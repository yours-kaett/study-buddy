<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>ICT Study-Buddy</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../bootstrap/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.ico">
        <style>
            .background-waiting {
                background-color: #0000008f;
                width: 100%;
                height: 100%;
                position: absolute;
                z-index: 1;
            }

            .waiting {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 350px;
                background-color: #0000008f;
                color: #fff;
            }

            .waiting p {
                margin-top: 18px;
                display: flex;
                justify-content: center;
                padding: 10px;
            }
        </style>
    </head>

    <body onload="loaderFunction()">
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2">
                <h4 class="fw-bolder mt-2 ms-1">Challenge Mode</h4>
                <a href="account.php" class="me-1">
                    <img src="../../img/profile.jpg" alt="">
                </a>
            </div>
        </header>
        <main>
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
            <div class="container practice">
                <div class="card">
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
                                <h5 class="mb-5">Topic: ' . $rows['topic_title'] . ' </h5>
                            ';

                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE topic_id = ? AND student_id = ? ');
                            $stmt->bind_param('ii', $topic_id, $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (mysqli_num_rows($result) > 0) {
                                // $student_answer = '';
                                // $stmt = $conn->prepare(' UPDATE tbl_practice_duo SET student_answer = ? WHERE topic_id = ? AND student_id = ?  ');
                                // $stmt->bind_param('sii', $student_answer, $topic_id, $_SESSION['id']);
                                // $stmt->execute();
                            } else {
                                // $stmt = $conn->prepare(' SELECT * FROM tbl_invite_practice WHERE topic_id = ? ');
                                // $stmt->bind_param('i', $topic_id);
                                // $stmt->execute();
                                // $result = $stmt->get_result();
                                // $row = $result->fetch_assoc();
                                // $room_id = $row['room_id'];

                                // $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
                                // $stmt->bind_param('i', $topic_id);
                                // $stmt->execute();
                                // $result = $stmt->get_result();
                                // if ($result->num_rows > 0) {
                                //     while ($rows = $result->fetch_assoc()) {
                                //         $topic_id = $rows["topic_id"];
                                //         $item_number = $rows["item_number"];
                                //         $question = $rows["question"];
                                //         $choice1 = $rows["choice1"];
                                //         $choice2 = $rows["choice2"];
                                //         $choice3 = $rows["choice3"];
                                //         $choice4 = $rows["choice4"];
                                //         $correct_answer = $rows["correct_answer"];

                                //         $stmt = $conn->prepare(' INSERT INTO tbl_practice_duo 
                                //         (topic_id, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_id, room_id) 
                                //         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
                                //         $stmt->bind_param("iissssssii", $topic_id, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $_SESSION['id'], $room_id);
                                //         $stmt->execute();
                                //     }
                                // }
                            }

                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
                            $stmt->bind_param('i', $topic_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($rows = $result->fetch_assoc()) {
                                $item_number = $rows['item_number'];
                                $question = $rows['question'];
                                $choice1 = $rows['choice1'];
                                $choice2 = $rows['choice2'];
                                $choice3 = $rows['choice3'];
                                $choice4 = $rows['choice4'];
                                $correct_answer = $rows['correct_answer'];
                                $student_answer = $rows['student_answer'];
                                echo '
                                    <h6>' . $item_number . ". " . $question . '</h6>
                                    <fieldset class="row mb-4 mt-3">
                                        <div class="col-sm-10">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option1_' . $item_number . '" value="' . $choice1 . '" required>
                                                <label class="form-check-label" for="option1_' . $item_number . '">
                                                    ' . $choice1 . '
                                                </label>
                                            </div>
                                        </div3
                                        <div class="col-sm-10">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option2_' . $item_number . '" value="' . $choice2 . '" required>
                                                <label class="form-check-label" for="option2_' . $item_number . '">
                                                    ' . $choice2 . '
                                                </label>
                                            </div>
                                        </div3
                                        <div class="col-sm-10">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option3_' . $item_number . '" value="' . $choice3 . '" required>
                                                <label class="form-check-label" for="option3_' . $item_number . '">
                                                    ' . $choice3 . '
                                                </label>
                                            </div>
                                        </div3
                                        <div class="col-sm-10">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option4_' . $item_number . '" value="' . $choice4 . '" required>
                                                <label class="form-check-label" for="option4_' . $item_number . '">
                                                    ' . $choice4 . '
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>
                                    ';
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
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-5">
                <a href="home.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-house fs-5 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1;">
                    <i class="bi bi-collection-fill fs-5 fw-bolder"></i>
                    Topics
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-grid-3x3-gap fs-5 fw-bolder"></i>
                    Take quiz
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-bell fs-5 fw-bolder"></i>
                    <span>Notifications
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
}
