<?php
include '../db-connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $stmt = $conn->prepare(' SELECT * FROM tbl_quiz_student WHERE quiz_code = ? ');
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($rows = $result->fetch_assoc()) {
        $stmt = $conn->prepare(' UPDATE tbl_quiz_student SET student_answer = ? WHERE item_number = ? AND quiz_code = ? ');
        foreach ($_POST['answers'] as $item_number => $selected_answer) {
            $stmt->bind_param('ssi', $selected_answer, $item_number, $_GET['id']);
            $stmt->execute();
        }
    }
    $stmt->close();
    header('Location: ../pages/student/quiz-output.php?id=' . $_GET['id'] . '');
    exit();
} else {
    echo "Error.";
}
