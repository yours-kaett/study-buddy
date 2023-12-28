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

            <div class="container starters">
                <div class="card w-100 mt-5 mb-5 p-3">
                    <div class="card-body">
                        <!-- success & error -->
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-2" role="alert">
                                <div>
                                    <?php echo $_GET['success']; ?>
                                    <a href="add-topic.php">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        if (isset($_GET['error'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center mb-2" role="alert">
                                <div>
                                    <?php echo $_GET['error'], "Error inserting Sub Topic data."; ?>
                                    <a href="add-topic.php">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="../../backend/add-topic-sanitize.php" method="POST" class="mb-4 w-100">
                            <div class="w-100 mb-3">
                                <label>Topic title</label>
                                <input type="text" name="topic_title" placeholder="Type here" class="form-control w-100" required>
                            </div>
                            <div id="rows-container"></div>
                            <button class="btn btn-primary btn-sm" id="addRow" type="button">
                                <i class="bi bi-plus-lg"></i>&nbsp; Add
                            </button>
                            <div class="w-100 mt-5">
                                <button class="btn-login w-100 d-flex align-items-center justify-content-center" type="submit">
                                    <span id="login">Save</span>
                                    <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
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
                <a href="topics.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-collection fs-3 fw-bolder"></i>
                    Topics
                </a>
                <a href="add-topic.php" class="d-flex flex-column align-items-center" style="color: #3552a1">
                    <i class="bx bxs-layer-plus fw-bolder" style="font-size: 40px;"></i>
                </a>
                <a href="setup-quiz.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-pencil fs-3 fw-bolder"></i>
                    Setup Quiz
                </a>
                <a href="#" class="d-flex flex-column align-items-center">
                    <i class="bx bx-group fs-3 fw-bolder"></i>
                    Students
                </a>
            </div>
        </footer>

        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../script.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const addRowButton = document.getElementById("addRow");
                const rowsContainer = document.getElementById("rows-container");
                let rowCounter = 0;
                let itemNumber = 1;
                addRowButton.addEventListener("click", function() {
                    const newRow = document.createElement("div");
                    newRow.classList.add("row", "d-flex", "align-items-center");
                    newRow.innerHTML = `
                        <div class="col-lg-2 col-sm-12">
                            <label>Lesson #</label>
                            <input type="text" name="lesson_number_${rowCounter}" value="${itemNumber++}" placeholder="Type here" class="form-control mb-2 w-100" required>
                        </div>
                        <div class="col-lg-10 col-sm-12">
                            <label>Sub topic title</label>
                            <input type="text" name="sub_topic_title_${rowCounter}" placeholder="Type here" class="form-control mb-2 w-100" required>
                        </div>
                        <div class="col-lg-12">
                            <label>Discussion</label>
                            <textarea name="description_${rowCounter}" class="form-control mb-3" cols="30" rows="3" placeholder="Type here" required></textarea>
                        </div>
                        <hr>
                    `;
                    rowsContainer.appendChild(newRow);
                    rowCounter++;
                });
            });
        </script>
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