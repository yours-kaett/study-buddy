<?php
include "../../db-connection.php";
session_start();
if (isset($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
        $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id = ?');
        $stmt->bind_param('i', $student_id);
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
        <style>
            .home-notifications {
                position: absolute;
                padding-left: 5.5px;
                padding-right: 5.5px;
                padding-top: 2px;
                font-size: 8px;
                background-color: red;
                color: #fff;
                border: 2px solid #fff;
                border-radius: 50%;
                bottom: 75px;
                left: 20px;
            }
        </style>
    </head>

    <body>
        <main>
            <?php include '../../includes/refresher.php' ?>
            <div class="container starters min-vh-100">
                <img src="../../img/ICT-StudyBuddyLogo.png" width="150" alt="Study Buddy Logo">
                <h3 class="fw-bold mt-4">ICT Mobile Reviewer</h3>
                <div class="card">
                    <div class="w-100">
                        <a href="topics.php">
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-collection fs-3"></i>&nbsp; Topics
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="quiz-code-input.php">
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-pencil fs-3"></i>&nbsp; Quiz
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="#">
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-history fs-3"></i>&nbsp; History
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="notifications.php">
                            <button class="btn-b w-100 mt-2 relative">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-bell fs-3"></i>&nbsp; Notifications

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
                                            <span class="home-notifications" id="home-notifications">' . $notifications . '</span>
                                        ';
                                    if ($notifications === 0) {
                                        echo '
                                            <script>
                                                document.getElementById("home-notifications").style.display = "none";
                                            </script>
                                        ';
                                    } else {
                                        echo '
                                            <script>
                                                document.getElementById("home-notifications").style.display = "block";
                                            </script>
                                        ';
                                    }
                                    ?>
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="account.php">
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-user fs-3"></i>&nbsp; Account
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="../../logout.php">
                            <button class="btn-a w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-door-open fs-3"></i>&nbsp; Sign out
                                </span>
                            </button>
                        </a>
                    </div>
                </div>
        </main>
    </body>

    <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../script.js"></script>

    </html>

<?php
} else {
    header("Location: ../../student-login.php");
}
