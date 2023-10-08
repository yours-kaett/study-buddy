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
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.ico">
    </head>

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="fw-bolder mt-2">Self Practice</h4>
                <a href="account.php">
                    <img src="../../img/profile.jpg" alt="">
                </a>
            </div>
        </header>
        <main>
            <div class="container practice">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $stmt = $conn->prepare(' SELECT 
                        tbl_sub_topics.topic_id,
                        tbl_topics.topic_title
                        FROM tbl_sub_topics 
                        INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                        WHERE tbl_sub_topics.topic_id = ? ');
                        $stmt->bind_param('i', $_GET['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = $result->fetch_assoc();
                        echo '
                                <h5 class="mb-5">Topic: ' . $rows['topic_title'] . ' </h5>
                            ';

                        $stmt = $conn->prepare(' SELECT * FROM tbl_practice_student WHERE topic_id = ? AND student_id = ? ORDER BY id ASC');
                        $stmt->bind_param('ii', $_GET['id'], $_SESSION['id']);
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
                            $total_items = mysqli_num_rows($result);
                            echo '
                                <h6>' . $item_number . ". " . $question . '</h6>
                            ';
                            if ($student_answer !== '' && $student_answer === $correct_answer) {
                                echo '
                                    <h6 class="bg-success text-white p-2 mb-4 d-flex align-items-center">
                                        <span class="fs-4"><i class="bi bi-check"></i></span>&nbsp; &nbsp;
                                        <span>' . $student_answer . '</span> 
                                    </h6>
                                ';
                                $score += 1;
                            } else {
                                echo '
                                    <h6 class="bg-danger text-white mb-4 p-2 d-flex align-items-center">
                                        <span class="fs-4"><i class="bi bi-x"></i></span>&nbsp; &nbsp;
                                        <span>' . $student_answer . '</span> 
                                    </h6>
                                ';
                                $score += 0;
                            }
                        }
                        if ($score === $total_items) {
                            echo '
                            <hr>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="card w-100 d-flex flex-column justify-content-center align-items-center">
                                    <h6>Score Attained</h6>
                                    <h3>' . $score . ' out of ' . $total_items . '</h3>
                                    <h3 class="mt-3" style="color: #e6ca2d;">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <strong>PERFECT</strong>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </h3>
                                </div>
                            </div>
                            <hr>
                        ';
                        } else {
                            echo '
                            <hr>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="card w-100 d-flex flex-column justify-content-center align-items-center">
                                    <h6>Score Attained</h6>
                                    <h3>' . $score . ' out of ' . $total_items . '</h3>
                                </div>
                            </div>
                            <hr>
                        ';
                        }
                        ?>
                        <div class="w-100">
                            <a href="practice.php?id=<?php echo $_GET['id']; ?>">
                                <button class="btn-login w-100">
                                    Retake
                                </button>
                            </a>
                        </div>
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
