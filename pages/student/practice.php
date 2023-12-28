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

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="d-flex align-items-center justify-content-center fw-bolder mt-2">
                    <a onclick="goBack()"><i class="bx bx-chevron-left fs-1"></i></a>
                    <span class="pb-1">&nbsp;Self Learning</span>
                </h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="container practice mt-5 mb-3">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="../../backend/practice-submit.php?id=<?php echo $_GET['id'] ?>" method="POST">
                            <?php
                            $stmt = $conn->prepare(' SELECT 
                            tbl_practice.topic_id,
                            tbl_topics.topic_title
                            FROM tbl_practice 
                            INNER JOIN tbl_topics ON tbl_practice.topic_id = tbl_topics.id
                            WHERE tbl_practice.topic_id = ? ');
                            $stmt->bind_param('i', $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            echo '
                                <h5 class="fw-bold mb-5 mt-3">Topic: ' . $rows['topic_title'] . ' </h5>
                            ';

                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice_student WHERE topic_id = ? AND student_id = ? ');
                            $stmt->bind_param('ii', $_GET['id'], $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if (mysqli_num_rows($result) > 0) {
                                $student_answer = '';
                                $stmt = $conn->prepare(' UPDATE tbl_practice_student SET student_answer = ? WHERE topic_id = ? AND student_id = ?  ');
                                $stmt->bind_param('sii', $student_answer, $_GET['id'], $_SESSION['id']);
                                $stmt->execute();
                            } else {
                                $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
                                $stmt->bind_param('i', $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while ($rows = $result->fetch_assoc()) {
                                        $topic_id = $rows["topic_id"];
                                        $item_number = $rows["item_number"];
                                        $question = $rows["question"];
                                        $choice1 = $rows["choice1"];
                                        $choice2 = $rows["choice2"];
                                        $choice3 = $rows["choice3"];
                                        $choice4 = $rows["choice4"];
                                        $correct_answer = $rows["correct_answer"];
                                        $stmt = $conn->prepare(' INSERT INTO tbl_practice_student 
                                    (topic_id, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ');
                                        $stmt->bind_param("iissssssi", $topic_id, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $_SESSION['id']);
                                        $stmt->execute();
                                    }
                                }
                            }
                            $topic_id = $_GET['id'];
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
                                            <input class="form-check-input  border-5" type="radio" name="answers[' . $item_number . ']" id="option' . ($index + 1) . '_' . $item_number . '" value="' . $choice . '" required>
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
                            <div class="d-flex">
                                <button class="btn-reset w-50 d-flex align-items-center justify-content-center p-2" type="reset">
                                    Reset
                                </button>&nbsp; &nbsp;
                                <button class="btn-login fw-bold d-flex align-items-center justify-content-center w-100" type="submit" onclick="submitFn()">
                                    <span id="login">Submit</span>
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
                    <i class="bx bx-home-alt fs-3 fw-bolder"></i>
                    <span class="fw-bold">Home</span>
                </a>
                <a href="#" class="d-flex flex-column align-items-center" style="color: #3552a1;">
                    <i class="bx bxs-collection fs-3 fw-bolder"></i>
                    <span class="fw-bold">Topics</span>
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-pencil fs-3 fw-bolder"></i>
                    <span class="fw-bold">Quiz</span>
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center">
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
            function submitFn() {
                document.getElementById('login').style.display = "none"
                document.getElementById('spinner').style.display = "flex"
                document.getElementById('spinner').style.alignItems = "center"
                document.getElementById('spinner').style.justifyContent = "center"
            }
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
