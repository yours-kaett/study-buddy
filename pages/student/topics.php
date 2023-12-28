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
        <style>
            .topic-card {
                margin: 0;
                padding: 0;
            }
            .topic-card:hover {
                box-shadow: 0 12px 12px 0 rgba(0, 0, 0, 0.10), 0 15px 20px 0 rgba(0, 0, 0, 0.30);
                transition: 05.s;
            }

            .topic-module {
                display: inline-block;
                background: linear-gradient(to right, #008156, #000);
                background-size: 200% 100%;
                transition: background-position 0.5s ease-in-out;
            }

            .topic-module:hover {
                background-position: right center;
                animation: gradientMove 2s infinite alternate;
                transition: background-position 0.5s ease-in-out;
                }

                @keyframes gradientMove {
                to {
                    background-position: left center;
                }
            }
        </style>
    </head>

    <body>
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="d-flex align-items-center justify-content-center fw-bolder mt-2">
                    <a onclick="goBack()"><i class="bx bx-chevron-left fs-1"></i></a>
                    <span class="pb-1">&nbsp;Topics</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="container topic mt-5 mb-3">
                <div class="card w-100 mt-3 mb-5 p-3">
                    <div class="row">
                        <?php
                        $stmt = $conn->prepare(' SELECT * FROM tbl_topics ORDER BY id DESC ');
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $topic_title = $row['topic_title'];
                            $filename = $row['filename'];
                            echo '
                                <div class="col-lg-1 col-md-1 col-sm-3 mb-2 w-50 topic-card">
                                    <a href="download-module.php?id=' . $id . '">
                                        <div class="d-flex align-items-center flex-column topic-module pt-4">
                                            <img src="../../img/word.png" alt="Microsoft Logo" style="width: 50px;" class="rounded">
                                            <span class="container text-center text-white small m-4">' . $topic_title . '</span>
                                        </div>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="test.php?id='. $id .'" class="small w-100">
                                            <button class="btn btn-outline-primary btn-sm rounded-0 w-100" type="button">
                                                <i class="bx bx-pencil"></i>&nbsp; Test
                                            </button>
                                        </a>
                                        <a href="https://docs.google.com/viewerng/viewer?url=http://studybuddy.free.nf/modules/'.$filename.'" target="_blank" class="small w-100" >
                                            <button class="btn btn-outline-primary btn-sm rounded-0 w-100" type="button">
                                                <i class="bx bx-show"></i>&nbsp; View
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                ';
                        }
                        ?>
                    </div>
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