<?php
include '../db-connection.php';
session_start();

if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
    if (
        isset($_FILES['img_url']) && isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname']) && isset($_POST['email'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $firstname = validate($_POST['firstname']);
        $middlename = validate($_POST['middlename']);
        $lastname = validate($_POST['lastname']);
        $email = validate($_POST['email']);
        $img_name = $_FILES['img_url']['name'];
        $img_size = $_FILES['img_url']['size'];
        $tmp_name = $_FILES['img_url']['tmp_name'];
        $error = $_FILES['img_url']['error'];

        $stmt = $conn->prepare(" SELECT * FROM tbl_teacher WHERE firstname = ? AND middlename = ? AND lastname = ? AND email = ? ");
        $stmt->bind_param("ssss", $firstname, $middlename, $lastname, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../pages/teacher/account.php?exist");
            exit();
        } else {
            if ($error === 0) {
                if ($img_size > 10000000) {
                    header("Location: ../pages/teacher/account.php?too_large.");
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        // $new_img_url = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = '../uploads/profile/' . $img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                        $stmt = $conn->prepare(' UPDATE tbl_teacher SET img_url = ?, firstname = ?, middlename = ?, lastname = ?, email = ? WHERE id = ? ');
                        $stmt->bind_param('sssssi', $img_name, $firstname, $middlename, $lastname, $email, $userId);
                        $stmt->execute();
                        header("Location: ../pages/teacher/account.php?success");
                        exit();
                    } else {
                        header("Location: ../pages/teacher/account.php?invalid_type.");
                        exit();
                    }
                }
            }
        }
    } else {
        header('Location: ../pages/teacher/account.php?unknown');
        exit();
    }
} else {
    header('Location ../../index.php');
    exit();
}
