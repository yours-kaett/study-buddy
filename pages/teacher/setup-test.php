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
                <h4 class="fw-bolder mt-2">Setup Test</h4>
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

                            $stmt = $conn->prepare(' SELECT 
                            tbl_sub_topics.id,
                            tbl_sub_topics.topic_id,
                            tbl_topics.topic_title
                            FROM tbl_sub_topics 
                            INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                            WHERE tbl_sub_topics.topic_id = ? ');
                            $stmt->bind_param('i', $_GET['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $rows = $result->fetch_assoc();
                            $topic_title = $rows['topic_title'];
                            ?>
                            <div class="w-100 mb-3">
                                <input type="text" name="topic_id" value="<?php echo $id ?>" style="display: none;" class="starters-input w-100" required>
                            </div>
                            <div class="w-100 mb-3">
                                <input type="text" value="<?php echo $topic_title ?>" style="display: flex;" class="starters-input w-100" readonly>
                            </div>
                            <div id="rows-container"></div>
                            <button class="btn btn-primary" id="addRow" type="button">
                                <i class="bi bi-plus-lg"></i>&nbsp; Add
                            </button>
                            <div class="w-100 mt-5">
                                <button class="btn-login w-100 d-flex align-items-center justify-content-center" type="submit">
                                    <span id="login"><i class="bi bi-save"></i>&nbsp; Save</span>
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
                    <i class="bi bi-house fs-5 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1">
                    <i class="bi bi-collection-fill fs-5 fw-bolder"></i>
                    Topics
                </a>
                <a href="#" class="d-flex flex-column align-items-center">
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

    </body>

    </html>

    <!-- <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Deserunt quam omnis distinctio reiciendis, eius voluptatibus? Cum ex officia unde optio ab. Dicta cupiditate ipsam accusamus alias rem et nisi iste.
    Accusantium perferendis dicta rem, tempore iure sunt eius vero, magnam veritatis tempora, error quo iusto! Neque excepturi beatae nobis cupiditate nesciunt placeat, officiis non, totam sed, ex consectetur temporibus eveniet.
    Sit itaque laboriosam at nihil quasi vel explicabo temporibus iusto vitae tenetur, consequatur sequi non fugit, soluta tempore amet autem. Rem ex ab id commodi, quos ea blanditiis enim velit!
    Ex at minima nemo totam incidunt omnis vel magni, non illo. Laborum dolor quibusdam voluptas accusantium id libero earum minima, odit in architecto amet at unde nesciunt aliquam? Harum, consequatur.
    Earum nihil unde natus? Excepturi, repudiandae. Voluptatum quasi iure aperiam! Quaerat, velit deserunt. Quam aliquam repudiandae tenetur molestias maxime animi ex consectetur autem? Maiores delectus adipisci tempora, deserunt facilis unde.
    Tenetur laboriosam, doloremque dolor minima tempore laudantium. Cum facilis eius itaque, pariatur suscipit ut voluptatem illo mollitia? Reprehenderit, nostrum non atque magnam officia tenetur doloremque provident, ipsam eius totam dicta.
    Doloremque, dolorum consequatur voluptatum enim nam vero eius omnis maxime praesentium, molestiae, reprehenderit impedit fuga beatae repudiandae molestias neque explicabo laborum autem tenetur. Assumenda aperiam vel, reiciendis corporis iusto blanditiis!
    Explicabo doloremque fugit quod id debitis aperiam officia odit. Laboriosam iure iusto nemo, deleniti tempora quidem non tenetur excepturi optio deserunt voluptate quas cum modi repudiandae praesentium illo laudantium velit!
    Fuga iure odio hic reprehenderit debitis perspiciatis nisi corporis sequi placeat perferendis deserunt quibusdam eaque quis, consectetur molestias soluta asperiores tenetur similique? Magni similique sequi quae, qui dolor molestiae voluptate?
    Nostrum quo nesciunt corporis culpa laborum aspernatur porro hic quaerat eligendi provident. At perspiciatis aliquam, tempore hic eligendi necessitatibus rem nobis expedita totam harum architecto quisquam reprehenderit ut. Necessitatibus, cum.</p> -->

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>