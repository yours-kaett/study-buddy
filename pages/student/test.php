<?php
include '../../db-connection.php';
session_start();
if (isset($_SESSION['id'])) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousUrl = $_SERVER['HTTP_REFERER'];
    } else {
        $previousUrl = 'home.php';
    }
    $userId = $_SESSION['id'];
    $topic_id = $_GET['id'];
    $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id = ?');
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
        <link rel="stylesheet" href="../../boxicons/css/boxicons.min.css">
        <link rel="stylesheet" href="../../style.css">
        <link rel="icon" href="../../img/ICT-StudyBuddyLogo.png">
        <script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>

    </head>

    <body onload="generateRoomID()">
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="d-flex align-items-center justify-content-center fw-bolder mt-2">
                    <a onclick="goBack()"><i class="bx bx-chevron-left fs-1"></i></a>
                    <span class="pb-1">&nbsp;Test</span>
                </h4>
                <a href="account.php">
                    <img src="../../uploads/profile/<?php echo $img_url ?>" alt="Profile" width="30" height="30" style="border-radius: 50%;">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>

            <div class="container topic mt-5 mb-3">
                <div class="card mb-5">
                    <div class="card-body p-5">
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center mb-4 mt-3" role="alert">
                                <?php echo $_GET['success']; ?>
                                <a href="sub-topics.php?id=<?php echo $topic_id ?>">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }

                        $stmt = $conn->prepare('SELECT id, topic_title FROM tbl_topics WHERE id = ?');
                        $stmt->bind_param('i', $topic_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = $result->fetch_assoc();
                        $topic_title = $rows['topic_title'];
                        echo '
                            <h5 class="fw-bold mb-5">Topic: ' . $topic_title . ' </h5>
                        ';

                        if (mysqli_num_rows($result) == 0) {
                            echo "<div class='d-flex align-items-center flex-column mt-5 pt-5'>
                                    <i class='bx bx-task-x text-secondary' style='font-size: 80px;'></i>
                                    <h6 class='text-secondary fw-bold mt-3'>There's no discussion here.</h6>
                                    <h6 class='text-secondary fw-bold mt-1'>You can go back here soon.</h6>
                                    <a href='topics.php' class='mt-3'>
                                        <button class='btn btn-outline-success border-2 d-flex align-items-center fw-bold'>
                                            <i class='bx bx-left-arrow-alt fs-5'></i>
                                            Back to Topics
                                        </button>
                                    </a>
                                </div>";
                        } else {
                            echo '
                            <a href="practice.php?id=' . $topic_id . '">
                                <button type="button" class="btn-a rounded-5 w-100 mb-2 fw-bold text-white">Self practice</button>
                            </a>
                            <button type="button" class="btn-b rounded-5 w-100 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#inviteModal">Challenge a friend</button>
                        ';
                        }
                        ?>
                        <div class="modal" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content rounded-0">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 fw-bold" id="inviteModalLabel">Challenge a friend</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id <> ?');
                                        $stmt->bind_param('i', $userId);
                                        $stmt->execute();
                                        $student_result = $stmt->get_result();
                                        while ($student_row = $student_result->fetch_assoc()) {
                                            $challenger_id = $student_row['id'];
                                            echo '<form action="confirmation-invitation.php?invite_to=' . $challenger_id . '" method="POST">';
                                        }
                                        echo '<p>Room ID:
                                                <span>
                                                    <input name="room_id" id="roomID" class="fw-bold" type="text" style="background-color: transparent; border: none; outline: none;" readonly />
                                                </span>
                                            </p>';
                                        $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id <> ?');
                                        $stmt->bind_param('i', $userId);
                                        $stmt->execute();
                                        $student_result = $stmt->get_result();
                                        while ($student_row = $student_result->fetch_assoc()) {
                                            $challenger_id = $student_row['id'];
                                            $img_url = $student_row['img_url'];
                                            $firstname = $student_row['firstname'];
                                            $middlename = $student_row['middlename'];
                                            $lastname = $student_row['lastname'];
                                            echo '<form action="confirmation-invitation.php?invite_to=' . $challenger_id .
                                                '" method="POST">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <input type="number" name="topic_id" value="' . $topic_id . '" style="display: none;">
                                                            <img src="../../img/' . $img_url .
                                                '" width="45" height="45" class="avatar" />
                                                            <p class="small mt-3 ms-2">' . $firstname . ' ' . $middlename . ' ' . $lastname .
                                                '</p>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-sm">Invite</button>
                                                    </div>
                                                </form>
                                            ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
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
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1;">
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
                        $stmt = $conn->prepare('SELECT * FROM tbl_invite_practice WHERE invite_to = ? AND invite_status_id = ?');
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

        <!-- <script src="../../script.js"></script> -->
        <script>
            /* ROOM ID GENERATOR */
            function generateRoomID() {
                let length = 4;
                let charset = "0123456789";
                let room_id = "";
                for (let i = 0, n = charset.length; i < length; ++i) {
                    room_id += charset.charAt(Math.floor(Math.random() * n));
                }
                document.getElementById("roomID").value = room_id;
            }

            function goBack() {
                window.location.href = "<?php echo $previousUrl; ?>";
            }
        </script>
    </body>

    </html>

<?php
} else {
    header('Location: ../../index.php');
    exit();
}
?>