<?php
include "../db-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $quiz_code = validate($_POST['quiz_code']);

    $stmt = $conn->prepare(' SELECT student_answer FROM tbl_quiz_student WHERE quiz_code = ? AND student_id = ? ');
    $stmt->bind_param('si', $quiz_code, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    if (!empty($rows['student_answer'])) {
        header("Location: ../pages/student/quiz-code-input.php?error=You were already done with the quiz based on your quiz code.");
        exit();
    } else {
        $stmt = $conn->prepare(' SELECT quiz_code FROM tbl_quiz WHERE quiz_code = ? ');
        $stmt->bind_param('s', $quiz_code);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../pages/student/quiz.php?id=" . $rows['quiz_code'] . "");
            exit();
        } else {
            header("Location: ../pages/student/quiz-code-input.php?error=Quiz code not found.");
            exit();
        }
    }
} else {
    header("Location: ../pages/student/quiz-code-input.php?error=Unknown error occurred.");
    exit();
}
