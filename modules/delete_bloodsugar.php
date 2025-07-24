<?php
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['System God', 'Admin'])) {
    die("Unauthorized access.");
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token.");
}

require '../config/db.php';

$id = $_POST['id'] ?? null;
$tenant_id = $_SESSION['tenant_id'];

if ($id) {
    // Ensure the record belongs to this tenant
    $stmt = $conn->prepare("DELETE FROM bloodsugarlevel WHERE id = ? AND tenant_id = ?");
    $stmt->bind_param("ii", $id, $tenant_id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Record deleted successfully.";
        } else {
            $_SESSION['message'] = "Delete failed: Record not found or not allowed.";
        }
    } else {
        $_SESSION['message'] = "Delete failed: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
header("Location: viewresults.php");
exit;
