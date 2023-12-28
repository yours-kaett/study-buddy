<?php
include "../db-connection.php";
session_start();
if (isset($_POST["submit"])) {
    $targetDir = "../modules/";
    $filename = basename($_FILES["fileToUpload"]["name"]);
    $targetFile = $targetDir . $filename;
    $tmp_name = $_FILES['fileToUpload']['tmp_name'];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array("pdf", "doc", "docx");
    if (!in_array($imageFileType, $allowedExtensions)) {
        header("Location: ../pages/teacher/topics.php?not_allowed");
        exit();
    } else {
        if (file_exists($targetFile)) {
            header("Location: ../pages/teacher/topics.php?file_exist");
            exit();
        } else {
            if ($_FILES["fileToUpload"]["size"] > 100000000) {
                header("Location: ../pages/teacher/topics.php?too_large");
                exit();
            } else {
                function validate($data)
                {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }
                $topic_title = validate($_POST['topic_title']);
                $teacher_id = $_SESSION['id'];
                date_default_timezone_set('Asia/Manila');
                $created_at = date("F j, Y | l - h:i:s a");
                $stmt = $conn->prepare("SELECT * FROM tbl_topics WHERE topic_title = ?");
                $stmt->bind_param("s", $topic_title);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    header("Location: ../pages/teacher/topics.php?topic_exist");
                    exit();
                } else {
                    $upload_path = $targetDir . $filename;
                    move_uploaded_file($tmp_name, $upload_path);
                    $stmt = $conn->prepare("INSERT INTO tbl_topics (topic_title, filename, filepath, teacher_id, created_at) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param('sssis', $topic_title, $filename, $upload_path, $teacher_id, $created_at);
                    $stmt->execute();
                    header("Location: ../pages/teacher/topics.php?success");
                    exit();
                }
            }
        }
    }
}
