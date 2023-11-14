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
                <h4 class="fw-bolder mt-2">Quiz Code</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $_SESSION['img_url'] ?>" alt="">
                </a>
            </div>
        </header>
        <main>
            <?php
            if (isset($_GET['warning'])) {
            ?>
                <div class="alert alert-warning rounded-0 border-0 alert-dismissible fade show d-flex align-items-center justify-content-center fixed-bottom" style="margin-bottom: 53px !important;" role="alert">
                    <span class="fw-bold small"><?php echo $_GET['warning'], "You've already took the quiz based on quiz code."; ?></span>
                    <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            if (isset($_GET['error'])) {
            ?>
                <div class="alert alert-danger rounded-0 border-0 alert-dismissible fade show d-flex align-items-center justify-content-center fixed-bottom" style="margin-bottom: 53px !important;" role="alert">
                    <span class="fw-bold small"><?php echo $_GET['error'], "Quiz Code not found."; ?></span>
                    <button type="button" class="btn-close small" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            ?>
            <div class="container starters min-vh-100">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="../../backend/quiz-code-sanitize.php" method="POST" class="w-100 mb-4 mt-5">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="quiz_code" class="fw-bold">Quiz Code</label>
                                    <?php
                                    if (isset($_GET['quiz_code'])) {
                                    ?>
                                        <input type="text" name="quiz_code" value="<?php echo $_GET['quiz_code'] ?>" class="starters-input w-100" id="quiz_code" required>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="text" name="quiz_code" placeholder="Type here" class="starters-input w-100" id="quiz_code" required>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="w-100">
                                <button class="btn-login fw-bold d-flex align-items-center justify-content-center w-100" type="submit">
                                    <span id="login">Join</span>
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
                <a href="#" class="d-flex flex-column align-items-center mt-2" style="color: #3552a1;">
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>