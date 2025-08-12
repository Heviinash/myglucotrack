<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'System God') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Handle AJAX update by dropdown change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['status'])) {
    $userId = intval($_POST['user_id']);
    $newStatus = $_POST['status'];

    // Validate status value
    $validStatuses = ['Active', 'Inactive'];
    if (!in_array($newStatus, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status value']);
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Optionally keep the old form update method for backward compatibility
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

// If no valid POST request
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit();
