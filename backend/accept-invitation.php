<?php
include '../db-connection.php';
session_start();

$invite_status_id = 3;
$stmt = $conn->prepare(' UPDATE tbl_invite_practice SET invite_status_id = ? WHERE id = ? ');
$stmt->bind_param('ii', $invite_status_id, $_GET['id']);
$stmt->execute();

$stmt = $conn->prepare(' SELECT * FROM tbl_invite_practice WHERE id = ? ');
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$topic_id = $row['topic_id'];
$room_id = $row['room_id'];

$stmt = $conn->prepare(' SELECT * FROM tbl_practice WHERE topic_id = ? ');
$stmt->bind_param('i', $topic_id);
$stmt->execute();
$result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $topic_id = $row["topic_id"];
        $item_number = $row["item_number"];
        $question = $row["question"];
        $choice1 = $row["choice1"];
        $choice2 = $row["choice2"];
        $choice3 = $row["choice3"];
        $choice4 = $row["choice4"];
        $correct_answer = $row["correct_answer"];

        $stmt = $conn->prepare(' INSERT INTO tbl_practice_duo 
        (topic_id, item_number, question, choice1, choice2, choice3, choice4, correct_answer, student_id, room_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
        $stmt->bind_param("iissssssii", $topic_id, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $_SESSION['id'], $room_id);
        $stmt->execute();
    }


header('Location: ../pages/student/practice-duo.php?id=' . $room_id . '');
exit();
