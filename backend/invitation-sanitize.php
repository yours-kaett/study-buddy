<?php
include '../db-connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }

    $student_id = $_SESSION['id'];
    $invite_to = validate($_POST['invite_to']);
    $invite_status = 2;
    $practice_status = 1;
    $topic_id = $_GET['id'];
    $room_id = validate($_POST['room_id']);
    $stmt = $conn->prepare("INSERT INTO tbl_invite_practice (invite_from, invite_to, invite_status_id, practice_status_id, topic_id, room_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('iiiiis', $student_id, $invite_to, $invite_status, $practice_status, $topic_id, $room_id);
    $stmt->execute();

    $stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
    $stmt->bind_param('i', $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_assoc()) {
            $item_number = $rows["item_number"];
            $question = $rows["question"];
            $choice1 = $rows["choice1"];
            $choice2 = $rows["choice2"];
            $choice3 = $rows["choice3"];
            $choice4 = $rows["choice4"];
            $correct_answer = $rows["correct_answer"];

            $stmt = $conn->prepare(' INSERT INTO tbl_practice_duo 
            (topic_id, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_id, room_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
            $stmt->bind_param("iissssssis", $topic_id, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $student_id, $room_id);
            $stmt->execute();
        }
    }

    header('Location: ../pages/student/practice-duo.php?id='. $room_id .' ');
    exit();
} else {
    echo "Error.";
}
