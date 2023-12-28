<?php
include '../db-connection.php';
session_start();

if ($_SESSION['id']) {
    $userId = $_SESSION['id'];
    if (
        isset($_FILES['img_url']) && isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname']) &&
        isset($_POST['phone_number']) && isset($_POST['email']) && isset($_POST['grade_level']) && isset($_POST['section'])
    ) {
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
        $phone_number = validate($_POST['phone_number']);
        $email = validate($_POST['email']);
        $grade_level = validate($_POST['grade_level']);
        $section = validate($_POST['section']);
        $img_name = $_FILES['img_url']['name'];
        $img_size = $_FILES['img_url']['size'];
        $tmp_name = $_FILES['img_url']['tmp_name'];
        $error = $_FILES['img_url']['error'];

        $stmt = $conn->prepare(" SELECT * FROM tbl_student WHERE firstname = ? AND middlename = ? AND lastname = ? AND phone_number = ? and email = ? AND grade_level = ? AND section = ? ");
        $stmt->bind_param("sssssii", $firstname, $middlename, $lastname, $phone_number, $email, $grade_level, $section);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../pages/student/account.php?exist");
            exit();
        } else {
            if ($error === 0) {
                if ($img_size > 10000000) {
                    header("Location: ../pages/student/account.php?too_large.");
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        // $new_img_url = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = '../uploads/profile/' . $img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
                        $stmt = $conn->prepare(' UPDATE tbl_student SET img_url = ?, firstname = ?, middlename = ?, lastname = ?, phone_number = ?, email = ?, grade_level = ?, section = ? WHERE id = ? ');
                        $stmt->bind_param('ssssssiii', $img_name, $firstname, $middlename, $lastname, $phone_number, $email, $grade_level, $section, $userId);
                        $stmt->execute();
                        header("Location: ../pages/student/account.php?success");
                        exit();
                    } else {
                        header("Location: ../pages/student/account.php?invalid_type.");
                        exit();
                    }
                }
            }
        }
    } else {
        header('Location: ../pages/student/account.php?unknown');
        exit();
    }
} else {
    header('Location ../../index.php');
    exit();
}
