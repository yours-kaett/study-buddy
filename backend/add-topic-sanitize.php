<?php
include "../db-connection.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(trim($data));
    }
    $userId = $_SESSION['id'];
    $topic_title = validate($_POST['topic_title']);

    $stmt = $conn->prepare("SELECT id, topic_title FROM tbl_topics WHERE topic_title = ?");
    $stmt->bind_param("s", $topic_title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../pages/teacher/add-topic.php?error=Topic title already exist.");
        exit();
    } else {

        $stmt = $conn->prepare("INSERT INTO tbl_topics (topic_title, teacher_id) VALUES (?, ?)");
        $stmt->bind_param('si', $topic_title, $userId);
        $stmt->execute();
        $topic_id = $stmt->insert_id;

        $rowCounter = 0;
        while (isset($_POST["lesson_number_$rowCounter"]) && 
            isset($_POST["sub_topic_title_$rowCounter"])&& 
            isset($_POST["description_$rowCounter"]) ) {

            $lesson_number = validate($_POST["lesson_number_$rowCounter"]);
            $sub_topic_title = validate($_POST["sub_topic_title_$rowCounter"]);
            $description = validate($_POST["description_$rowCounter"]);
            
            $stmt = $conn->prepare("INSERT INTO tbl_sub_topics (topic_id, lesson_number, sub_topic_title, description) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiss', $topic_id, $lesson_number, $sub_topic_title, $description);
            $stmt->execute();
            if ($stmt->error) {
                header("Location: ../pages/teacher/add-topic.php?error");
                exit();
            }
            $rowCounter++;
        }

        header("Location: ../pages/teacher/topics.php");
        exit();
    }
} else {
    header("Location: ../pages/teacher/topics.php?error=Unknown error occurred.");
    exit();
}
