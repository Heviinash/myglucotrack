<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../auth/login.php");
    exit();
}

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $tenant_id = $_SESSION['tenant_id'];

    $stmt = $conn->prepare("DELETE FROM patient WHERE id = ? AND tenant_id = ?");
    $stmt->bind_param("ii", $id, $tenant_id);


    if ($stmt->execute()) {
        $_SESSION['success'] = "Patient deleted successfully.";
    } else {
        $_SESSION['error'] = "Failed to delete patient.";
    }

    $stmt->close();
}

header("Location: patient.php");
exit();
