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
                <a href="home.php" class="">
                    <i class="bi bi-arrow-left fs-2"></i>
                </a>
                <h4 class="fw-bolder mt-2">ICT Topics</h4>
                <a href="account.php">
                    <img src="../../img/profile.jpg" alt="">
                </a>
            </div>
        </header>
        <main>
            <div class="container starters min-vh-100">
                <div class="card w-100 mt-5 mb-5 p-3">
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_topics ');
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($rows = $result->fetch_assoc()) {
                        echo '
                    <div class="w-100">
                        <a href="sub-topics.php?id=' . $rows['id'] . '">
                            <button class="btn-a w-100 mt-2 d-flex justify-content-between">
                                <i class="bi bi-code-slash"></i>&nbsp; ' . $rows['topic_title'] . '
                                <i class="bi bi-chevron-double-right"></i>
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
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-5">
                <a href="home.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-house fs-5 fw-bolder"></i>
                    Home
                </a>
                <a href="#" class="d-flex flex-column align-items-center" style="color: #3552a1;">
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
    exit();
}

?>