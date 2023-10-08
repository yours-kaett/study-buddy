<?php
include '../../db-connection.php';
session_start();

if (($_SESSION['username']) && ($_SESSION['id'])) {
    $student_id = $_SESSION['id'];
    $topic_id = $_GET['id'];
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

    <body onload="generateRoomID()">
        <header>
            <div class="d-flex align-items-center justify-content-between top-0 fixed-top p-2 mx-2">
                <h4 class="fw-bolder mt-2">ICT Topics</h4>
                <a href="account.php">
                    <img src="../../img/profile.jpg" alt="">
                </a>
            </div>
        </header>
        <main>
            <div class="container topic">
                <div class="card">
                    <div class="card-body">
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

                        $stmt = $conn->prepare(' SELECT 
                        tbl_sub_topics.topic_id,
                        tbl_topics.topic_title
                        FROM tbl_sub_topics 
                        INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                        WHERE tbl_sub_topics.topic_id = ? ');
                        $stmt->bind_param('i', $topic_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $rows = $result->fetch_assoc();
                        // $topic_id = $rows['topic_id'];
                        $topic_title = $rows['topic_title'];
                        echo '
                            <h5>Topic: ' . $topic_title . ' </h5>
                        ';

                        $stmt = $conn->prepare(' SELECT 
                        tbl_sub_topics.topic_id,
                        tbl_topics.topic_title,
                        tbl_topics.id as route_topic_id,
                        tbl_sub_topics.sub_topic_title,
                        tbl_sub_topics.description
                        FROM tbl_sub_topics 
                        INNER JOIN tbl_topics ON tbl_sub_topics.topic_id = tbl_topics.id
                        WHERE tbl_sub_topics.topic_id = ? ');
                        $stmt->bind_param('i', $topic_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($rows = $result->fetch_assoc()) {
                            echo '
                            <div class="container">
                                <h5 class="text-center mt-4 mb-4">' . $rows['sub_topic_title'] . '</h5>
                            </div>
                            <div class="container">
                                <p class="small">' . $rows['description'] . '</p>
                            </div>
                            ';
                        }
                        echo '
                            <a href="practice.php?id=' . $topic_id . '">
                                <button type="button" class="btn-login w-100 mb-2">Self practice</button>
                            </a>
                            <button type="button" class="btn-login w-100" data-bs-toggle="modal" data-bs-target="#inviteModal">Challenge a friend</button>
                        ';
                        ?>
                        <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="inviteModalLabel">Challenge a friend</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                    // $invite_status_id = 2;
                                    // $stmt = $conn->prepare(' SELECT
                                    // tbl_invite_practice.invite_status_id,
                                    // tbl_invite_practice.invite_to,
                                    // tbl_student.id,
                                    // tbl_student.img_url,
                                    // tbl_student.firstname,
                                    // tbl_student.middlename,
                                    // tbl_student.lastname
                                    // FROM tbl_invite_practice
                                    // INNER JOIN tbl_student ON tbl_invite_practice.invite_to = tbl_student.id
                                    // WHERE tbl_invite_practice.invite_status_id <> ? AND tbl_invite_practice.invite_from <> ? ');
                                    // $stmt->bind_param('ii', $invite_status_id, $student_id);
                                    // $stmt->execute();
                                    // $student_result = $stmt->get_result();
                                    // if (mysqli_num_rows($student_result) > 0) {
                                    //     while ($student_row = $student_result->fetch_assoc()) {
                                    //         echo '
                                    //             <div class="d-flex align-items-center justify-content-between">
                                    //                 <div class="d-flex align-items-center justify-content-between">
                                    //                     <img src="../../img/' . $student_row['img_url'] . '" width="45" height="45" class="avatar" />
                                    //                     <p class="small mt-3 ms-2">' . $student_row['firstname'] . ' ' . $student_row['middlename'] . ' ' . $student_row['lastname'] . '</p>
                                    //                 </div>
                                    //                 <input name="invite_to" value="' . $student_row['id'] . '" style="display: none;">
                                    //                 <button class="btn btn-primary btn-sm" type="submit">In-game</button>
                                    //             </div>';
                                    //     }
                                    // }

                                    echo '<form action="../../backend/invitation-sanitize.php?id=' . $topic_id . '" method="POST">';
                                    echo '
                                            <p>Room ID:
                                                <span>
                                                    <input name="room_id" id="roomID" type="text" style="background-color: transparent; border: none; outline: none;" readonly />
                                                </span>
                                            </p>';

                                    $stmt = $conn->prepare(' SELECT id, img_url, firstname, middlename, lastname  FROM tbl_student WHERE id <> ? ');
                                    $stmt->bind_param('i', $student_id);
                                    $stmt->execute();
                                    $student_result = $stmt->get_result();
                                    while ($student_row = $student_result->fetch_assoc()) {
                                        echo '
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <img src="../../img/' . $student_row['img_url'] . '" width="45" height="45" class="avatar" />
                                                        <p class="small mt-3 ms-2">' . $student_row['firstname'] . ' ' . $student_row['middlename'] . ' ' . $student_row['lastname'] . '</p>
                                                    </div>
                                                    <input name="invite_to" value="' . $student_row['id'] . '" style="display: none;">
                                                    <button class="btn btn-primary btn-sm" type="submit">Invite</button>
                                                </div>';
                                        }
                                    echo '</form>';

                                        $stmt->close();
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <a href="topics.php" class="d-flex flex-column align-items-center" style="color: #3552a1;">
                    <i class="bi bi-collection-fill fs-5 fw-bolder"></i>
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
    header('Location ../../index.php');
    exit();
}

?>