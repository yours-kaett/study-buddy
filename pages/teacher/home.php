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
        <link rel="stylesheet" href="../../bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.png">
    </head>

    <body>
        <main>
            <div class="container starters min-vh-100">
                <img src="../../img/ICT-StudyBuddyLogo.png" width="150" alt="Study Buddy Logo">
                <h3 class="fw-bold mt-4">ICT Mobile Reviewer</h3>
                <div class="card">
                    <div class="w-100">
                        <a href="topics.php">
                            <button class="btn-b w-100 mt-2">
                                <span>
                                    <i class="bi bi-collection"></i>&nbsp; Topics
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="setup-quiz.php">
                            <button class="btn-b w-100 mt-2">
                                <span>
                                    <i class="bi bi-grid-3x3-gap"></i>&nbsp; Setup Quiz
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="#">
                            <button class="btn-b w-100 mt-2">
                                <span>
                                    <i class="bi bi-people"></i>&nbsp; Students
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="#">
                            <button class="btn-b w-100 mt-2">
                                <span>
                                    <i class="bi bi-clock-history"></i>&nbsp; User history
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="#">
                            <button class="btn-b w-100 mt-2">
                                <span>
                                    <i class="bi bi-gear"></i>&nbsp; Settings
                                </span>
                            </button>
                        </a>
                    </div>
                    <div class="w-100">
                        <a href="../../logout.php">
                            <button class="btn-a w-100 mt-2">
                                <span>
                                    <i class="bi bi-box-arrow-left"></i>&nbsp; Sign out
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
