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
    $stmt = $conn->prepare(' SELECT 
    tbl_student.id,
    tbl_student.firstname,
    tbl_student.middlename,
    tbl_student.lastname,
    tbl_student.email,
    tbl_student.phone_number,
    tbl_student.img_url,
    tbl_student.grade_level AS g_level,
    tbl_grade_level.grade_level,
    tbl_section.section,
    tbl_student.section AS sec
    FROM tbl_student
    INNER JOIN tbl_grade_level ON tbl_student.grade_level = tbl_grade_level.id
    INNER JOIN tbl_section ON tbl_student.section = tbl_section.id
    WHERE tbl_student.id = ? ');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $firstname = $rows['firstname'];
    $middlename = $rows['middlename'];
    $lastname = $rows['lastname'];
    $email = $rows['email'];
    $phone_number = $rows['phone_number'];
    $g_level = $rows['g_level'];
    $sec = $rows['sec'];
    $grade_level = $rows['grade_level'];
    $section = $rows['section'];
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
                        <form action="../../backend/update-student-account.php" method="POST" class="mb-4" enctype="multipart/form-data">
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
                                    <label>Phone Number</label>
                                    <input type="number" name="phone_number" value="<?php echo $phone_number ?>" class="starters-input w-100 mb-2" required>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo $email ?>" class="starters-input w-100 mb-2" required>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Grade Level</label>
                                    <select name="grade_level" class="starters-input w-100 mb-2">
                                        <option value="<?php echo $g_level ?>"><?php echo $grade_level ?></option>
                                        <?php
                                        $blank = '';
                                        $stmt = $conn->prepare('SELECT * FROM tbl_grade_level WHERE grade_level <> ? AND grade_level <> ?');
                                        $stmt->bind_param('ss', $grade_level, $blank);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $grade_level = $row['grade_level'];
                                            echo "<option value='$id'>$grade_level</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <label>Section</label>
                                    <select name="section" class="starters-input w-100 mb-2">
                                        <option value="<?php echo $sec ?>"><?php echo $section ?></option>
                                        <?php
                                        $blank = '';
                                        $stmt = $conn->prepare('SELECT * FROM tbl_section WHERE section <> ? AND section <> ?');
                                        $stmt->bind_param('ss', $section, $blank);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $section = $row['section'];
                                            echo "<option value='$id'>$section</option>";
                                        }
                                        ?>
                                    </select>
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
            <div class="d-flex align-items-center justify-content-between bottom-0 fixed-bottom px-5">
                <a href="home.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-home-alt fs-3 fw-bolder"></i>
                    <span class="fw-bold">Home</span>
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center">
                    <i class="bx bx-collection fs-3 fw-bolder"></i>
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