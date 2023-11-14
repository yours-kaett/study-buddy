<?php
include "../../db-connection.php";
session_start();
if (isset($_SESSION['username'])) {
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
        <main>
            <div class="container starters min-vh-100">
                <img src="../../img/ICT-StudyBuddyLogo.png" width="150" alt="Study Buddy Logo">
                <h5 class="mt-4 fw-bold">ICT Mobile Reviewer</h5>
                <div class="card">
                    <div class="card-body">
                        <a href="topics.php">
                            <button class="btn-b d-flex align-items-center justify-content-center w-100 mt-2 ps-5 pe-5 fw-bold">
                                <i class="bx bx-book-open fs-5"></i>&nbsp; Topics
                            </button>
                        </a>
                        <a href="quiz-code-input.php">
                            <button class="btn-b d-flex align-items-center justify-content-center w-100 mt-2 ps-5 pe-5 fw-bold">
                                <i class="bx bx-grid-alt fs-5"></i>&nbsp; Take Quiz
                            </button>
                        </a>
                        <a href="notifications.php">
                            <button class="btn-b d-flex align-items-center justify-content-center w-100 mt-2 ps-5 pe-5 fw-bold">
                                <i class="bx bx-bell fs-5"></i>&nbsp; Notifications
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn-b d-flex align-items-center justify-content-center w-100 mt-2 ps-5 pe-5 fw-bold">
                                <i class="bx bx-history fs-5"></i>&nbsp; User history
                            </button>
                        </a>
                        <a href="../../logout.php">
                            <button class="btn-a d-flex align-items-center justify-content-center w-100 mt-2 ps-5 pe-5 fw-bold">
                                <i class="bx bx-log-out fs-5"></i>&nbsp; Sign out
                            </button>
                        </a>
                    </div>
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
