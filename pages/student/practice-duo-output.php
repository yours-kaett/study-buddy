<?php
include '../../db-connection.php';
session_start();
if (($_SESSION['id'])) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } else {
        $previousUrl = 'home.php';
    }
    $userId = $_SESSION['id'];
    $topic_id = $_GET['id'];
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
                    <span class="pb-1">&nbsp;Challenge Mode Test</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>
            <div class="container practice">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $room_id = $_GET['id'];
                        $stmt = $conn->prepare(' SELECT * FROM tbl_invite_practice WHERE room_id = ? ');
                        $stmt->bind_param('i', $room_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $topic_id = $row['topic_id'];

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
                        $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE topic_id = ? AND student_id = ? AND room_id = ? ORDER BY item_number ASC');
                        $stmt->bind_param('iii', $topic_id, $_SESSION['id'], $room_id);
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
                                        <span class="fs-4"><i class="bx bx-check"></i></span>&nbsp; &nbsp;
                                        <span>' . $student_answer . '</span> 
                                    </h6>
                                ';
                                $score += 1;
                            } else {
                                echo '
                                    <h6 class="bg-danger text-white mb-4 p-2 d-flex align-items-center">
                                        <span class="fs-4"><i class="bx bx-x"></i></span>&nbsp; &nbsp;
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
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <strong>PERFECT</strong>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
                                        <i class="bx bxs-star"></i>
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

                        $stmt = $conn->prepare('SELECT * FROM tbl_invite_practice WHERE room_id = ?');
                        $stmt->bind_param('i', $room_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $invite_from = $row['invite_from'];
                        $invite_to = $row['invite_to'];
                        $stmt = $conn->prepare('SELECT * FROM tbl_practice_duo WHERE room_id = ?');
                        $stmt->bind_param('i', $room_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $opponent_score = 0;
                        while ($row = $result->fetch_assoc()) {
                            $student_id = $row['student_id'];
                            $student_answer = $row['student_answer'];
                            $correct_answer = $row['correct_answer'];
                            if ($student_answer === '') {
                                $opponent_score = 'on progress...';
                            }
                            if ($student_answer === $correct_answer) {
                                if ($student_id !== $_SESSION['id']) {
                                    $opponent_score++;
                                }
                            }
                        }

                        echo "<h6>Opponent's Score: <span class='fs-3'>$opponent_score</span></h6>";
                        echo '
                            <a href="topics.php">
                                <button class="btn btn-primary btn-sm d-flex align-items-center mt-3">
                                    <i class="bx bx-left-arrow-alt fs-5"></i>
                                    &nbsp;Back to Topics
                                </button>
                            </a>
                        ';

                        $practice_status_id = 2;
                        $stmt = $conn->prepare(' UPDATE tbl_invite_practice SET practice_status_id = ? WHERE room_id = ? ');
                        $stmt->bind_param('ii', $practice_status_id, $room_id);
                        $stmt->execute();

                        $stmt->close();

                        ?>
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
