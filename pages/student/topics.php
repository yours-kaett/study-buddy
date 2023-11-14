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
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.ico">
    </head>

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 border">
                <h4 class="fw-bolder mt-2">ICT Topics</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $_SESSION['img_url'] ?>" alt="">
                </a>
            </div>
        </header>
        <main>
            <div class="container topic mt-5 mb-3">
                <div class="card w-100 mt-3 mb-5 p-3">
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_topics ');
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($rows = $result->fetch_assoc()) {
                        echo '
                    <div class="w-100">
                        <a href="sub-topics.php?id=' . $rows['id'] . '">
                            <button class="btn-a w-100 mt-2 d-flex align-items-center justify-content-between">
                                <i class="bx bx-code-alt fs-5"></i>
                                <span class="fw-bold">' . $rows['topic_title'] . '</span>
                                <i class="bx bxs-chevrons-right fs-5"></i>
                            </button>
                        </a>
                    </div>
                    ';
                    }
                    ?>
                </div>
            </div>
        </main>

        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-5 border">
                <a href="home.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-home fs-3 fw-bolder"></i>
                    Home
                </a>
                <a href="#" class="d-flex flex-column align-items-center mt-2" style="color: #3552a1;">
                    <i class="bx bxs-book-open fs-3 fw-bolder"></i>
                    Topics
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center mt-2">
                    <i class="bx bx-grid-alt fs-3 fw-bolder"></i>
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>