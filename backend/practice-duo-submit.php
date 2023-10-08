<?php
include '../db-connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {

    $stmt = $conn->prepare(' SELECT * FROM tbl_invite_practice WHERE room_id = ? ');
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $topic_id = $row['topic_id'];

    $stmt = $conn->prepare(' SELECT * FROM tbl_practice_duo WHERE topic_id = ? ');
    $stmt->bind_param('i', $topic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($rows = $result->fetch_assoc()) {
        $stmt = $conn->prepare(' UPDATE tbl_practice_duo SET student_answer = ? WHERE item_number = ? AND topic_id = ? AND student_id = ? ');
        foreach ($_POST['answers'] as $item_number => $selected_answer) {
            $stmt->bind_param('ssii', $selected_answer, $item_number, $topic_id, $_SESSION['id']);
            $stmt->execute();
        }
    }
    $stmt->close();
    header('Location: ../pages/student/practice-duo-output.php?id=' . $_GET['id'] . '');
    exit();
} else {
    echo "Error.";
}
