<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
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
                <h4 class="fw-bolder mt-2">Topics</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
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
                                <i class="bx bx-code-alt fs-3"></i>&nbsp; ' . $rows['topic_title'] . '
                                <i class="bx bx-chevrons-right fs-3"></i>
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
                    <i class="bx bx-home-alt fs-3 fw-bolder"></i>
                    <span class="fw-bold">Home</span>
                </a>
                <a href="#" class="d-flex flex-column align-items-center" style="color: #3552a1;">
                    <i class="bx bxs-collection fs-3 fw-bolder"></i>
                    <span class="fw-bold">Topics</span>
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-pencil fs-3 fw-bolder"></i>
                    <span class="fw-bold">Quiz</span>
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center">
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>