<?php
session_start();
require '../config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['admin_password'])) {
    $adminId = $_SESSION['user_id'];
    $adminTenant = $_SESSION['tenant_id'];

    $userId = intval($_POST['user_id']);
    $adminPasswordInput = $_POST['admin_password'];

    // Step 1: Verify admin password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ? AND role = 'Admin' AND tenant_id = ?");
    $stmt->bind_param("ii", $adminId, $adminTenant);
    $stmt->execute();
    $stmt->bind_result($hashedAdminPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($adminPasswordInput, $hashedAdminPassword)) {
        echo json_encode(['success' => false, 'message' => 'Incorrect admin password.']);
        exit();
    }

    // Step 2: Generate new password
    $tempPassword = bin2hex(random_bytes(4)); // 8-char random
    $hashedTemp = password_hash($tempPassword, PASSWORD_DEFAULT);

    // Step 3: Update user password
   $stmt = $conn->prepare("UPDATE users SET password = ?, is_temp_password = 1 WHERE id = ? AND tenant_id = ?");
   $stmt->bind_param("sii", $hashedTemp, $userId, $adminTenant);

    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "New Password: $tempPassword"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reset password.']);
    }

    $stmt->close();
    exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid request.']);

