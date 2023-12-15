<?php
include '../../db-connection.php';
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $invite_to = $_POST['invite_to'];
        $topic_id = $_GET['id'];
        $room_id = $_POST['room_id'];

        echo $invite_to;

        $student_id = $_SESSION['id'];
        $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id = ?');
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        $img_url = $rows['img_url'];

        $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE id = ?');
        $stmt->bind_param('i', $invite_to);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        $firstname = $rows['firstname'];
    }
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
                <h4 class="fw-bolder mt-2">ICT Topics</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <div class="container topic">
                <div class="card">
                    <div class="card-body">
                        <?php

                        $stmt = $conn->prepare('SELECT id, topic_title FROM tbl_topics WHERE id = ?');
                        $stmt->bind_param('i', $topic_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = $result->fetch_assoc();
                        $topic_title = $rows['topic_title'];
                        echo '
                            <h5>Topic: ' . $topic_title . ' </h5>
                        ';

                        ?>
                        <form action="../../backend/invitation-sanitize.php?id=<?php echo $topic_id ?>" method="POST">
                            <div class="d-flex flex-column">
                                <!-- Other name appear -->
                                <h5 class="text-center mt-4 mb-4">Are you sure you want to challenge <?php echo $firstname; ?> ?</h5>
                                <input type="text" name="invite_to" value="<?php echo $invite_to ?>" style="display: none;">
                                <input type="text" name="room_id" value="<?php echo $room_id ?>" style="display: none;">
                                <div class="d-flex align-items justify-content-evenly">
                                    <a href="sub-topics.php?id=<?php echo $topic_id ?>" class="btn btn-sm btn-secondary w-25">
                                        <button type="button" class="btn text-white">No</button>
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-primary w-25">Yes</button>
                                </div>
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
        </script>
    </body>

    </html>

<?php
} else {
    header('Location: ../../index.php');
    exit();
}
?>