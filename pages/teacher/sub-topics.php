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
                <a href="topics.php" class="">
                    <i class="bi bi-arrow-left fs-2"></i>
                </a>
                <div></div>
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
            <div class="container topic">
                <div class="card">
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
                        <div class="container mt-3">
                            <h5>Topic: ' . $rows['topic_title'] . ' </h5>
                        </div>
                    ';

                    $stmt = $conn->prepare(' SELECT 
                    tbl_sub_topics.topic_id,
                    tbl_topics.topic_title,
                    tbl_topics.id as route_topic_id,
                    tbl_sub_topics.sub_topic_title,
                    tbl_sub_topics.description
                    FROM tbl_sub_topics 
                    INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                    WHERE tbl_sub_topics.topic_id = ? ');
                    $stmt->bind_param('i', $_GET['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($rows = $result->fetch_assoc()) {
                        echo '
                            <div class="container mb-4">
                                <h1 class="text-center mt-4">' . $rows['sub_topic_title'] . '</h1>
                            </div>
                            <div class="container">
                                <p>' . $rows['description'] . '</p>
                            </div> ';
                    }
                    echo '
                        <a href="setup-test.php?id=' . $_GET['id'] . '" class="d-flex">
                            <button type="button" class="btn-take-quiz">
                                <i class="bi bi-plus"></i>&nbsp; Setup Test
                            </button>
                        </a> ';
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
                <a href="#" class="d-flex flex-column align-items-center">
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