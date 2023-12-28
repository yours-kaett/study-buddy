<?php
include "../db-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $quiz_code = validate($_POST["quiz_code"]);
    $topic_title = validate($_POST["topic_title"]);
    $direction = validate($_POST["direction"]);
    $teacher_id = validate($_SESSION['id']);
    
    $rowCounter = 0;
    while (isset($_POST["item_number_$rowCounter"]) && 
        isset($_POST["question_$rowCounter"]) &&
        isset($_POST["choice1_$rowCounter"]) &&
        isset($_POST["choice2_$rowCounter"]) &&
        isset($_POST["choice3_$rowCounter"]) &&
        isset($_POST["choice4_$rowCounter"]) &&
        isset($_POST["correct_answer_$rowCounter"])) {

        $item_number = validate($_POST["item_number_$rowCounter"]);
        $question = validate($_POST["question_$rowCounter"]);
        $choice1 = validate($_POST["choice1_$rowCounter"]);
        $choice2 = validate($_POST["choice2_$rowCounter"]);
        $choice3 = validate($_POST["choice3_$rowCounter"]);
        $choice4 = validate($_POST["choice4_$rowCounter"]);
        $correct_answer = validate($_POST["correct_answer_$rowCounter"]);

        $stmt = $conn->prepare("INSERT INTO tbl_quiz 
        (quiz_code, direction, topic_title, item_number, question, choice1, choice2, choice3, choice4, correct_answer, teacher_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssissssssi', $quiz_code, $direction, $topic_title, $item_number, $question, $choice1, $choice2, $choice3, $choice4, $correct_answer, $teacher_id);
        $stmt->execute();
        if ($stmt->error) {
            header("Location: ../pages/teacher/setup-quiz.php?error=Error inserting test data.");
            exit();
        }
        $rowCounter++;
    }

    header("Location: ../pages/teacher/setup-quiz.php?success=Setting up quiz has been saved successfully!");
    exit();
} else {
    header("Location: ../pages/teacher/setup-quiz.php?error=Unknown error occurred.");
    exit();
}
