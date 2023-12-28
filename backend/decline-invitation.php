<?php
include '../db-connection.php';
session_start();

$invite_status_id = 3;
$stmt = $conn->prepare(' UPDATE tbl_invite_practice SET invite_status_id = ? WHERE id = ? ');
$stmt->bind_param('ii', $invite_status_id, $_GET['id']);
$stmt->execute();

$stmt = $conn->prepare(' DELETE FROM tbl_invite_practice WHERE invite_to = ? AND id = ? ');
$stmt->bind_param('ii', $_SESSION['id'], $_GET['id']);
$stmt->execute();

header('Location: ../pages/student/notifications.php');
exit();
