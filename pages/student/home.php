<?php
include "../../db-connection.php";
session_start();
if (isset($_SESSION['id'])) {
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
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-collection fs-3"></i>&nbsp; Topics
                                </span>
                            </button>
                        </a>
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
                            <button class="btn-b w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-bell fs-3"></i>&nbsp; Notifications
                                </span>
                                <span class="position-absolute"></span>
                            </button>
                        </a>
                        <a href="../../logout.php">
                            <button class="btn-a w-100 mt-2">
                                <span class="d-flex align-items-center justify-content-center">
                                    <i class="bx bx-door-open fs-3"></i>&nbsp; Sign out
                                </span>
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
