<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $userId = $_POST['update'];

    $newStatus = $_POST['status'][$userId];

    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $userId);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION['message'] = "Status updated.";
    header("Location: usercontrol.php");
    exit();
}
?>
