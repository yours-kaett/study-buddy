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
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="container topic mt-5 mb-3">
                <div class="card w-100 mt-3 mb-5 p-3">
                    <?php
                    if (isset($_GET['topic_exist'])) {
                    ?>
                        <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['topic_exist'], "Topic already exist."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['success'])) {
                    ?>
                        <div class="alert alert-success rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['success'], "Module imported successfully."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['too_large'])) {
                    ?>
                        <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['too_large'], "Your file is too large. Please import less then 100MB document."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['file_exist'])) {
                    ?>
                        <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['file_exist'], "File already exist."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['not_allowed'])) {
                    ?>
                        <div class="alert alert-warning rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['not_allowed'], "Your file is not allowed to upload. Please select DOC, DOCX or PDF only."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['test'])) {
                    ?>
                        <div class="alert alert-success rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['test'], "Test has been saved successfully."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['deleted'])) {
                    ?>
                        <div class="alert alert-success rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['delete'], "Module removed successfully."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['notfound'])) {
                    ?>
                        <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['notfound'], "Module not found."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    if (isset($_GET['request'])) {
                    ?>
                        <div class="alert alert-danger rounded-0 alert-dismissible fade show d-flex align-items-center justify-content-center w-100" role="alert">
                            <?php echo $_GET['request'], "Invalid request."; ?>
                            <a href="topics.php">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                    <button class="btn-b text-white mb-3 w-100" type="button" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                        <i class="bx bx-import"></i>&nbsp; Import Module
                    </button>
                    <div class="">
                        <?php
                        $stmt = $conn->prepare(' SELECT * FROM tbl_topics WHERE teacher_id = ? ORDER BY id DESC ');
                        $stmt->bind_param('i', $userId);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $topic_title = $row['topic_title'];
                            $filename = $row['filename'];
                            echo '
                                <div class="col-lg-1 col-md-1 col-sm-1 mb-3 w-100 topic-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="https://docs.google.com/viewerng/viewer?url=http://studybuddy.free.nf/modules/'.$filename.'" target="_blank" class="small w-100">
                                            <button class="btn btn-outline-primary btn-sm rounded-0 w-100" type="button">
                                                <i class="bx bx-show"></i>&nbsp; View Module
                                            </button>
                                        </a>
                                        <a class="small">
                                            <button class="btn btn-outline-danger btn-sm rounded-0 w-100" type="button" data-bs-toggle="modal" data-bs-target="#deleteTopicModal' . $id . '">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <a href="download-module.php?id=' . $id . '">
                                        <div class="d-flex align-items-center flex-column topic-module pt-4">
                                            <i class="bx bx-file text-white" style="font-size: 50px;"></i>
                                            <span class="title container text-center text-white small m-4">' . $topic_title . '</span>
                                        </div>
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="setup-test.php?id=' . $id . '" class="small w-100">
                                            <button class="btn btn-outline-success btn-sm rounded-0 w-100" type="button">
                                                <i class="bx bx-plus"></i>&nbsp; Test
                                            </button>
                                        </a>
                                        <a href="test.php?id=' . $id . '" class="small w-100">
                                            <button class="btn btn-outline-primary btn-sm rounded-0 w-100" type="button">
                                                <i class="bx bx-show"></i>&nbsp; Test
                                            </button>
                                        </a>
                                    </div>
                                </div>
                                <div class="modal" id="deleteTopicModal' . $id . '" tabindex="-1" aria-labelledby="deleteTopicModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content p-1 rounded-0">
                                            <form action="../../backend/delete-topic.php?id=' . $id . '" method="post" enctype="multipart/form-data" class="row p-2">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="deleteTopicModalLabel">Remove Module</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure you want to remove ' . $topic_title . ' module?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">No</button>
                                                    <button type="submit" class="btn btn-danger" id="loaderButton">
                                                        <span id="submitBlank">
                                                            <span id="submit">Yes</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="modal" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content p-1 rounded-0">
                        <form action="../../backend/add-topic-sanitize.php" method="post" enctype="multipart/form-data" class="row p-2">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addTopicModalLabel">Import Module</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 mb-4">
                                    <label for="topic_title">Topic Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bx-collection"></i>
                                        </span>
                                        <input type="text" name="topic_title" class="form-control" id="topic_title" placeholder="Type here..." required />
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="fileToUpload">Module</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bx bxs-file-doc"></i>
                                        </span>
                                        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" placeholder="Type here..." required />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-success" id="loaderButton">
                                    <span id="submitBlank">
                                        <span id="submit">Save</span>
                                    </span>
                                </button>
                            </div>
                        </form>
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
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1">
                    <i class="bx bxs-collection fs-3 fw-bolder"></i>
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