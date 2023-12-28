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
    $firstname = $rows['firstname'];
    $middlename = $rows['middlename'];
    $lastname = $rows['lastname'];
    $email = $rows['email'];
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
                    <span class="pb-1">&nbsp;Account</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>
            <div class="container starters">
                <div class="card mt-5 mb-5">
                    <div class="card-body p-4">

                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-primary alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 mb-3" role="alert">
                                <span class="text-primary"><?php echo $_GET['success'], "Account updated successfully."; ?></span>
                                <a href="account.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['exist'])) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 mb-3" role="alert">
                                <span class="text-primary"><?php echo $_GET['exist'], "Credential already exist."; ?></span>
                                <a href="account.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['unknown'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0 mb-3" role="alert">
                                <span class="text-danger"><?php echo $_GET['unknown'], "Unknown error occured."; ?></span>
                                <a href="account.php">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="../../backend/update-teacher-account.php" method="POST" class="mb-4" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center flex-column">
                                    <img src="../../uploads/profile/<?= $img_url ?>" width="120" height="120" alt="Profile" style="border-radius: 50%;" id="uploadedImg">
                                    <div class="pt-2 mb-3">
                                        <label for="upload" class="btn btn-primary btn-sm" tabindex="0">
                                            <span class="text-white">
                                                <i class="bx bx-upload"></i>
                                            </span>
                                            <input name="img_url" type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <a href="#" class="btn btn-danger btn-sm account-image-reset" title="Remove profile image"><i class="bx bx-trash"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>First Name</label>
                                    <input type="text" name="firstname" value="<?php echo $firstname ?>" class="starters-input w-100 mb-2" required>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Middle Name</label>
                                    <input type="text" name="middlename" value="<?php echo $middlename ?>" class="starters-input w-100 mb-2" required>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Last Name</label>
                                    <input type="text" name="lastname" value="<?php echo $lastname ?>" class="starters-input w-100 mb-2" required>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo $email ?>" class="starters-input w-100 mb-2" required>
                                </div>
                            </div>
                            <div class="w-100 my-2">
                                <button class="btn-a w-100 d-flex align-items-center justify-content-center" type="submit">
                                    <span id="login" class="d-flex align-items-center justify-content-center">
                                        <i class="bx bx-save fs-3"></i>&nbsp; Update
                                    </span>
                                    <span id="spinner" style="display: none; padding: 9px;" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                            <div class="w-100">
                                <a href="../../logout.php">
                                    <button class="btn-b w-100" type="button">
                                        <span class="d-flex align-items-center justify-content-center">
                                            <i class="bx bx-door-open fs-3"></i>&nbsp; Sign out
                                        </span>
                                    </button>
                                </a>
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
        <script>
        'use strict';
        document.addEventListener('DOMContentLoaded', function(e) {
            (function() {
                let accountUserImage = document.getElementById('uploadedImg');
                const fileInput = document.querySelector('.account-file-input'),
                    resetFileInput = document.querySelector('.account-image-reset');
                if (accountUserImage) {
                    const resetImage = accountUserImage.src;
                    fileInput.onchange = () => {
                        if (fileInput.files[0]) {
                            accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                        }
                    };
                    resetFileInput.onclick = () => {
                        fileInput.value = '';
                        accountUserImage.src = resetImage;
                    };
                }
            })();
        });
    </script>
    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>