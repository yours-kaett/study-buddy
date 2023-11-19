<?php
include "../db-connection.php";
session_start();

if ( isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])
) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $firstname = 'empty-fn';
    $middlename = 'empty-mn';
    $lastname = 'empty-ln';
    $img_url = 'default.png';

    $stmt = $conn->prepare(" SELECT * FROM tbl_teacher WHERE username = ? ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../teacher-signup.php?taken");
        exit();
    } else {
        
        $password = md5($password);
        $stmt = $conn->prepare("INSERT INTO tbl_teacher (firstname, middlename, lastname, email, username, password, img_url) 
        VALUES (?, ?, ?, ?, ?, ?, ?) ");
        $stmt->bind_param('sssssss', $firstname, $middlename, $lastname, $email, $username, $password, $img_url);
        $stmt->execute();
        $result = $stmt->get_result();
        header("Location: ../teacher-signup.php?success");
        exit();
    }
} else {
    header("Location: ../teacher-signup.php?unknown");
    exit();
}
