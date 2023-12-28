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
                    <span class="pb-1">&nbsp;Setup Test</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
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
                                    <a href="setup-test.php">
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
                                    <?php echo $_GET['error']; ?>
                                    <a href="setup-test.php">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="../../backend/setup-test-sanitize.php" method="POST" class="mb-4 w-100">
                            <?php
                            $stmt = $conn->prepare(' SELECT * FROM tbl_topics WHERE id = ? ');
                            $stmt->bind_param('i', $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            $id = $rows['id'];
                            $topic_title = $rows['topic_title'];
                            ?>
                            <div class="w-100 mb-3">
                                <input type="text" name="topic_id" value="<?php echo $id ?>" style="display: none;" class="starters-input w-100" required>
                            </div>
                            <div class="w-100 mb-3">
                                <input type="text" value="<?php echo $topic_title ?>" style="display: flex;" class="starters-input w-100" readonly>
                            </div>
                            <div id="rows-container"></div>
                            <button class="btn btn-primary btn-sm" id="addRow" type="button">
                                <i class="bx bx-plus"></i>&nbsp; Add item
                            </button>
                            <div class="w-100 mt-5">
                                <button class="btn-login w-100 d-flex align-items-center justify-content-center" type="submit">
                                    <span id="login" class="text-white"><i class="bx bx-save"></i>&nbsp; Save</span>
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
            document.addEventListener("DOMContentLoaded", function() {
                const addRowButton = document.getElementById("addRow");
                const rowsContainer = document.getElementById("rows-container");
                let rowCounter = 0;
                let itemNumber = 1;
                addRowButton.addEventListener("click", function() {
                    const newRow = document.createElement("div");
                    newRow.classList.add("row", "d-flex", "align-items-center");
                    newRow.innerHTML = `
                        <div class="col-lg-2">
                            <label>Item #</label>
                            <input type="number" name="item_number_${rowCounter}" value="${itemNumber++}"  placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-10">
                            <label>Question</label>
                            <input type="text" name="question_${rowCounter}" placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Choice 1</label>
                            <input type="text" name="choice1_${rowCounter}" placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Choice 2</label>
                            <input type="text" name="choice2_${rowCounter}" placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Choice 3</label>
                            <input type="text" name="choice3_${rowCounter}" placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-6">
                            <label>Choice 4</label>
                            <input type="text" name="choice4_${rowCounter}" placeholder="Type here" class="starters-input mb-2 w-100" required>
                        </div>
                        <div class="col-lg-12">
                            <label>Correct answer</label>
                            <input type="text" name="correct_answer_${rowCounter}" placeholder="Type here" class="starters-input mb-4 w-100" required>
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