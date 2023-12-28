<?php
include '../db-connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) {
        $topicId = $_GET['id'];

        $stmt = $conn->prepare('SELECT * FROM tbl_topics WHERE id = ?');
        $stmt->bind_param('i', $topicId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if (file_exists($row['filepath'])) {
                unlink($row['filepath']);
            }
            $deleteStmt = $conn->prepare('DELETE FROM tbl_topics WHERE id = ?');
            $deleteStmt->bind_param('i', $topicId);
            $deleteStmt->execute();
            header('Location: ../pages/teacher/topics.php?deleted');
            exit();
        } else {
            header('Location: ../pages/teacher/topics.php?notfound');
            exit();
        }
    } else {
        header('Location: ../pages/teacher/topics.php?request');
        exit();
    }
} else {
    header('Location: topics.php');
    exit();
}
?>
