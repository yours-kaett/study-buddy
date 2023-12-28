<?php
include('../../db-connection.php');
session_start();
if (isset($_SESSION['id'])) {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $stmt = $conn->prepare('SELECT filename, filepath FROM tbl_topics WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($filename, $filepath);
        
        if ($stmt->fetch()) {
            $fullPath = '../../modules/' . $filepath;
    
            if (file_exists($fullPath)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $filename);
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fullPath));
    
                readfile($fullPath);
                exit;
            } else {
                echo 'File not found.';
            }
        } else {
            echo 'Invalid topic ID.';
        }
    
        $stmt->close();
    } else {
        echo 'Invalid request.';
    }
} else {
    header("Location: ../index.php");
}


?>
