<?php
include '../../db-connection.php';
session_start();

if ($_SESSION['username']) {
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
                <div></div>
                <h4 class="fw-bolder mt-2">Profile</h4>
                <a href="account.php">
                    <img src="../../img/profile.jpg" alt="">
                </a>
            </div>
        </header>
        <main>
            <?php
            $stmt = $conn->prepare(' SELECT * FROM tbl_student WHERE username = ? ');
            $stmt->bind_param('s', $_SESSION['username']);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_assoc();
            $firstname = $rows['firstname'];
            $middlename = $rows['middlename'];
            $lastname = $rows['lastname'];
            $age = $rows['age'];
            $birthdate = $rows['birthdate'];
            $phone_number = $rows['phone_number'];
            ?>
            <div class="starters">
                <div class="card mt-5 mb-5">
                    <div class="card-body">
                        <form action="../backend/update-profile.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="d-flex align-items-center flex-column mt-5">
                                    <img src="../../img/profile.jpg" width="120" height="120" alt="Profile" class="profile" id="uploadedImg">
                                    <div class="pt-2">
                                        <label class="btn btn-outline-primary btn-sm" tabindex="0">
                                            <i class="bi bi-upload"></i>
                                            <input name="img_url" type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <a href="#" class="btn btn-outline-danger btn-sm account-image-reset" title="Remove profile image"><i class="bi bi-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100">
                                <label for="firstname" class="small">First Name</label>
                                <input name="firstname" type="text" class="starters-input w-100 mb-3 small" id="firstname" value="<?php echo $firstname ?>">
                            </div>
                            <div class="w-100">
                                <label for="middlename" class="small">Middle Name</label>
                                <input name="middlename" type="text" class="starters-input w-100 mb-3 small" id="middlename" value="<?php echo $middlename ?>">
                            </div>
                            <div class="w-100">
                                <label for="lastname" class="small">Last Name</label>
                                <input name="lastname" type="text" class="starters-input w-100 mb-3 small" id="lastname" value="<?php echo $lastname ?>">
                            </div>
                            <div class="w-100">
                                <label for="age" class="small">Age</label>
                                <input name="age" type="number" class="starters-input w-100 mb-3 small" id="age" value="<?php echo $age ?>">
                            </div>
                            <div class="w-100">
                                <label for="birthdate" class="small">Birthdate</label>
                                <input name="birthdate" type="text" class="starters-input w-100 mb-3 small" id="birthdate" value="<?php echo $birthdate ?>">
                            </div>
                            <div class="w-100">
                                <label for="phone_number" class="small">Phone</label>
                                <input name="phone_number" type="text" class="starters-input w-100 mb-3 small" id="phone_number" value="<?php echo $phone_number ?>">
                            </div>
                            <div class="w-100">
                                <label for="grade_level" class="small">Grade Level</label>
                                <select name="grade_level" id="grade_level" class="starters-input w-100 mb-3 small">
                                    <option disabled selected></option>
                                    <option value='1'>Grade 11</option>
                                    <option value='2'>Grade 12</option>
                                </select>
                            </div>
                            <div class="w-100">
                                <label for="section" class="small">Section</label>
                                <select name="section" id="section" class="starters-input w-100 mb-3 small">
                                    <option disabled selected></option>
                                    <option value='1'>Hope</option>
                                    <option value='2'>Faith</option>
                                    <option value='3'>Love</option>
                                </select>
                            </div>
                            <div class="w-100">
                                <label for="email" class="small">Email</label>
                                <input name="email" type="email" class="starters-input w-100 mb-3 small" id="email" value="<?php echo $rows['email'] ?>">
                            </div>
                            <div class="w-100 text-center">
                                <button type="submit" class="btn btn-outline-primary w-100">
                                    Save Changes
                                </button>
                            </div>
                            <div class="w-100 text-center mt-2">
                                <a href="../../logout.php">
                                    <button type="button" class="btn btn-outline-success w-100">
                                        Signout
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
                    <i class="bi bi-house fs-5 fw-bolder"></i>
                    Home
                </a>
                <a href="topics.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-collection fs-5 fw-bolder"></i>
                    Topics
                </a>
                <a href="quiz-code-input.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-grid-3x3-gap fs-5 fw-bolder"></i>
                    Take quiz
                </a>
                <a href="notifications.php" class="d-flex flex-column align-items-center">
                    <i class="bi bi-bell fs-5 fw-bolder"></i>
                    <span>Notifications
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
                        if ($notifications === 0)
                        {
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