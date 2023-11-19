<?php
session_start();
include "../db-connection.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $password = md5($password);
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_student WHERE username=? AND password=?");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $username, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['username'] === $username && $row['password'] === $password) {

                $_SESSION['id'] = $row['id'];

                header("Location: ../pages/student/home.php");
                exit();
            } else {
                header("Location: ../student-login.php?invalid");
                exit();
            }
        } else {
            header("Location: ../student-login.php?invalid");
            exit();
        }
    } catch (Exception $e) {
        header("Location: ../student-login.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../student-login.php?unknown");
    exit();
}
