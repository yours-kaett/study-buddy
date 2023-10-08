<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
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
                <h4 class="fw-bolder mt-2">Topics</h4>
                <a href="#">
                    <?php
                    $stmt = $conn->prepare(' SELECT * FROM tbl_teacher WHERE id = ? ');
                    $stmt->bind_param('i', $userId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $image = $row['img_url'];
                    echo '<img src="../../img/' . $image . '" width="40" alt="Profile"> ';
                    ?>
                </a>
            </div>
        </header>
        <main>
            <div class="container topic min-vh-100">
                <div class="card w-100 mb-5 p-3">
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
                            </div> ';
                    }
                    ?>
                </div>
            </div>
        </main>

        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-3">
                <a href="home.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-house fs-5 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1">
                    <i class="bi bi-collection-fill fs-5 fw-bolder"></i>
                    Topics
                </a>
                <a href="add-topic.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-patch-plus fs-1"></i>
                </a>
                <a href="setup-quiz.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-grid-3x3-gap fs-5 fw-bolder"></i>
                    Setup Quiz
                </a>
                <a href="#" class="d-flex flex-column align-items-center">
                    <i class="bi bi-people fs-5 fw-bolder"></i>
                    Students
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