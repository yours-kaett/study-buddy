<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['username']) {
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
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.ico">
    </head>

    <body onload="startCounter()">
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 border">
                <h4 class="fw-bolder mt-2">Quiz Mode</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $_SESSION['img_url'] ?>" alt="">
                </a>
            </div>
        </header>
        <main>
            <div class="container practice mt-5 mb-3">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="../../backend/quiz-submit.php?id=<?php echo $_GET['id'] ?>" method="POST">
                            <h4 class="text-success text-center mb-4 mt-3 fw-bold" id="timer">00:00</h4>
                            <?php
                            $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE quiz_code = ? AND student_id = ? ');
                            $stmt->bind_param('ii', $_GET['id'], $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            if (!empty($rows['student_answer'])) {
                                header("Location: home.php");
                                exit();
                            } else {

                                $stmt = $conn->prepare(' SELECT direction, topic_title FROM tbl_quiz WHERE quiz_code = ? ');
                                $stmt->bind_param('i', $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $rows = $result->fetch_assoc();
                                $direction = $rows['direction'];
                                $topic_title = $rows['topic_title'];
                                echo '
                                <h6>Direction: <span class="fw-bold">' . $direction . '</span></h6>
                                <h6 class="mt-3 mb-5">Topic: <span class="fw-bold">' . $topic_title . '</span></h6>
                            ';
                                $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE quiz_code = ? AND student_id = ? ');
                                $stmt->bind_param('ii', $_GET['id'], $_SESSION['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if (mysqli_num_rows($result) > 0) {
                                    $student_answer = '';
                                    $stmt = $conn->prepare(' UPDATE tbl_quiz_student SET student_answer = ? WHERE quiz_code = ? AND student_id = ?  ');
                                    $stmt->bind_param('sii', $student_answer, $_GET['id'], $_SESSION['id']);
                                    $stmt->execute();
                                } else {
                                    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE quiz_code = ? ');
                                    $stmt->bind_param('i', $_GET['id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        while ($rows = $result->fetch_assoc()) {
                                            $quiz_code = $rows["quiz_code"];
                                            $topic_title = $rows["topic_title"];
                                            $item_number = $rows["item_number"];
                                            $question = $rows["question"];
                                            $choice1 = $rows["choice1"];
                                            $choice2 = $rows["choice2"];
                                            $choice3 = $rows["choice3"];
                                            $choice4 = $rows["choice4"];
                                            $correct_answer = $rows["correct_answer"];

                                            $stmt = $conn->prepare(' INSERT INTO tbl_quiz_student 
                                    (quiz_code, topic_title, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
                                            $stmt->bind_param("ssissssssi", $quiz_code, $topic_title, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $_SESSION['id']);
                                            $stmt->execute();
                                        }
                                    }
                                }

                                $stmt = $conn->prepare(' SELECT * FROM tbl_quiz WHERE quiz_code = ? ORDER BY id ASC ');
                                $stmt->bind_param('i', $_GET['id']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($rows = $result->fetch_assoc()) {
                                    $topic_title = $rows['topic_title'];
                                    $item_number = $rows['item_number'];
                                    $question = $rows['question'];
                                    $choice1 = $rows['choice1'];
                                    $choice2 = $rows['choice2'];
                                    $choice3 = $rows['choice3'];
                                    $choice4 = $rows['choice4'];
                                    $correct_answer = $rows['correct_answer'];
                                    $student_answer = $rows['student_answer'];

                                    echo '
                                <h6 class="fw-bold">' . $item_number . ". " . $question . '</h6>
                                <fieldset class="row mb-4 mt-3">
                                    <div class="col-sm-10">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option1_' . $item_number . '" value="' . $choice1 . '" required>
                                            <label class="form-check-label" for="option1_' . $item_number . '">
                                                ' . $choice1 . '
                                            </label>
                                        </div>
                                    </div3
                                    <div class="col-sm-10">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option2_' . $item_number . '" value="' . $choice2 . '" required>
                                            <label class="form-check-label" for="option2_' . $item_number . '">
                                                ' . $choice2 . '
                                            </label>
                                        </div>
                                    </div3
                                    <div class="col-sm-10">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option3_' . $item_number . '" value="' . $choice3 . '" required>
                                            <label class="form-check-label" for="option3_' . $item_number . '">
                                                ' . $choice3 . '
                                            </label>
                                        </div>
                                    </div3
                                    <div class="col-sm-10">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="answers[' . $item_number . ']" id="option4_' . $item_number . '" value="' . $choice4 . '" required>
                                            <label class="form-check-label" for="option4_' . $item_number . '">
                                                ' . $choice4 . '
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                ';
                                }
                            }
                            ?>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <button class="btn-reset w-50 d-flex align-items-center justify-content-center p-2" type="reset">
                                    Reset
                                </button>&nbsp; &nbsp;
                                <button class="btn-login w-50 d-flex align-items-center justify-content-center p-2" type="submit" id="quiz-button">
                                    <span id=" submit">Submit</span>
                                    <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-5 border">
                <a href="home.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-home fs-3 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-book-open fs-3 fw-bolder"></i>
                    Topics
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center mt-2" style="color: #3552a1;">
                    <i class="bx bxs-grid-alt fs-3 fw-bolder"></i>
                    Take quiz
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-bell fs-3 fw-bolder"></i>
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
        <script>
            function startCounter() {
                let minutes = 1;
                seconds = minutes * 60;
                intervalHandle = setInterval(tick, 1000);
                document.getElementById("timer").style.fontStyle = "bold";
            }

            let seconds;
            let intervalHandle;

            function tick() {
                let timerDisplay = document.getElementById("timer");
                let min = Math.floor(seconds / 60);
                let sec = seconds - (min * 60);
                if (sec < 10) {
                    sec = "0" + sec;
                }
                let message = min.toString() + ":" + sec;
                timerDisplay.innerHTML = message;
                if (seconds === 0) {
                    alert("The timer has been stopped.");
                    clearInterval(intervalHandle);
                }
                seconds--;
            }

            function fnStop() {
                clearInterval(intervalHandle);
            }
        </script>

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
}
