<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
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
                <h4 class="fw-bolder mt-2">Test Viewing</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="starters">
                <div class="card w-100 mt-4 mb-5 p-3">
                    <div class="card-body">
                        <form action="#" method="POST">
                            <?php
                            $stmt = $conn->prepare(' SELECT * FROM tbl_topics WHERE id = ? ');
                            $stmt->bind_param('i', $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            echo '
                                <h6 class="fw-bold mb-5 mt-3">Topic: ' . $rows['topic_title'] . ' </h6>
                            ';

                            $topic_id = $_GET['id'];
                            $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
                            $stmt->bind_param('i', $topic_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows_array = array();
                            while ($row = $result->fetch_assoc()) {
                                $rows_array[] = $row;
                            }
                            shuffle($rows_array);
                            foreach ($rows_array as $rows) {
                                $item_number = $rows['item_number'];
                                $question = $rows['question'];
                                $choices = array(
                                    $rows['choice1'],
                                    $rows['choice2'],
                                    $rows['choice3'],
                                    $rows['choice4']
                                );
                                shuffle($choices);
                                echo '
                                    <h6>' . $question . '</h6>
                                    <fieldset class="row mb-4 mt-3">
                                ';
                                foreach ($choices as $index => $choice) {
                                    echo '
                                    <div class="col-sm-10">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input border-5" type="radio" name="answers[' . $item_number . ']" id="option' . ($index + 1) . '_' . $item_number . '" value="' . $choice . '" required>
                                            <label class="form-check-label" for="option' . ($index + 1) . '_' . $item_number . '">
                                                ' . $choice . '
                                            </label>
                                        </div>
                                    </div>
                                ';
                                }
                                echo '</fieldset>';
                            }
                            ?>
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>