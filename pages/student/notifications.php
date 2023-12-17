<?php
include '../../db-connection.php';
session_start();
if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
    $stmt = $conn->prepare(' SELECT * FROM tbl_student WHERE id = ? ');
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
                <h4 class="fw-bolder mt-2">Notifications</h4>
                <a href="account.php">
                    <img src="../../img/<?php echo $img_url ?>" alt="Profile" width="35">
                </a>
            </div>
        </header>
        <main>
            <?php include '../../includes/refresher.php' ?>
            <div class="container starters mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <?php
                                    $invite_status = 2;
                                    $stmt = $conn->prepare(' SELECT 
                                    tbl_invite_practice.id,
                                    tbl_invite_practice.invite_from,
                                    tbl_invite_practice.invite_to,
                                    tbl_invite_practice.invite_status_id,
                                    tbl_invite_practice.topic_id,
                                    tbl_student.firstname
                                    FROM tbl_invite_practice 
                                    INNER JOIN tbl_student ON tbl_invite_practice.invite_from = tbl_student.id
                                    WHERE tbl_invite_practice.invite_to = ? AND invite_status_id = ? ');
                                    $stmt->bind_param('ii', $_SESSION['id'], $invite_status);
                                    $stmt->execute();
                                    $invite_result = $stmt->get_result();
                                    while ($invite_rows = $invite_result->fetch_assoc()) {
                                        $stmt = $conn->prepare(' SELECT * FROM tbl_student WHERE id = ? ');
                                        $stmt->bind_param('i', $invite_rows['invite_from']);
                                        $stmt->execute();
                                        $student_result = $stmt->get_result();
                                        while ($student_rows = $student_result->fetch_assoc()) {
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_topics WHERE id = ? ');
                                            $stmt->bind_param('i', $invite_rows['topic_id']);
                                            $stmt->execute();
                                            $topic_result = $stmt->get_result();
                                            while ($topic_rows = $topic_result->fetch_assoc()) {
                                                echo '
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center small ms-2">
                                                                <img src="../../img/' . $student_rows['img_url'] . '" width="45" height="45" class="avatar" />
                                                                <div class="d-flex flex-column">
                                                                    <span class="ms-2">
                                                                        ' . $student_rows['firstname'] . ' ' . $student_rows['lastname'] . '
                                                                        challenge you to answer the questions from the topic ' . $topic_rows['topic_title'] . '.
                                                                    </span>
                                                                    <span>
                                                                        <a href="../../backend/accept-invitation.php?id=' . $invite_rows['id'] . '" class="small ms-2">
                                                                            <button class="btn btn-primary btn-sm mt-2">Accept</button>
                                                                        </a>
                                                                        <a href="../../backend/decline-invitation.php?id=' . $invite_rows['id'] . '" class="small">
                                                                            <button class="btn btn-outline-danger btn-sm mt-2">Decline</button>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
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
                <a href="notifications.php" class="d-flex flex-column align-items-center" style="color: #3552a1;">
                    <i class="bx bxs-bell fs-3 fw-bolder"></i>
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

    </body>

    </html>

<?php
} else {
    header('Location ../../index.php');
    exit();
}

?>