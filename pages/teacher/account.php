<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } else {
        $previousUrl = 'home.php';
    }
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_teacher WHERE id = ? ');
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
        <style>
            .topic-card {
                display: inline-block;
                background: linear-gradient(to right, #008156, #000);
                background-size: 200% 100%;
                transition: background-position 0.5s ease-in-out;
            }
        </style>
    </head>

    <body>
        <header>
        <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="d-flex align-items-center justify-content-center fw-bolder mt-2">
                    <a onclick="goBack()"><i class="bx bx-chevron-left fs-1"></i></a>
                    <span class="pb-1">&nbsp;Account</span>
                </h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="starters min-vh-100">
                <div class="card mt-5 mb-5">
                    <div class="card-body">
                        <img src="../../img/<?php echo $img_url ?>" width="120" height="120" alt="Profile" class="ms-5" style="border-radius: 50%;">
                        <div class="w-100">
                            <a href="../../logout.php">
                                <button class="btn-b w-100 mt-5">
                                    <span class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-door-open fs-3"></i>&nbsp; Sign out
                                    </span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer>
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-3">
                <a href="home.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-home-alt fs-3 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-collection fs-3 fw-bolder"></i>
                    Topics
                </a>
                <a href="setup-quiz.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-pencil fs-3 fw-bolder"></i>
                    Setup Quiz
                </a>
                <a href="students.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-group fs-3 fw-bolder"></i>
                    Students
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>
        <script>
            function goBack() {
                window.location.href = "<?php echo $previousUrl; ?>";
            }
        </script>

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>