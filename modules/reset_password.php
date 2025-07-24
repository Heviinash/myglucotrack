<?php
session_start();
require '../config/db.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Something went wrong'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_SESSION['user_id'] ?? null;
    $admin_password = $_POST['admin_password'] ?? '';
    $user_id = $_POST['user_id'] ?? '';

    if (!$admin_id || !$admin_password || !$user_id) {
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
        exit;
    }

    // 1. Verify admin password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $stmt->bind_result($adminHashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($admin_password, $adminHashedPassword)) {
        echo json_encode(['success' => false, 'message' => 'Invalid admin password']);
        exit;
    }

    // 2. Generate temp password
    $newPasswordPlain = bin2hex(random_bytes(4)); // Example: 8 char code
    $newPasswordHashed = password_hash($newPasswordPlain, PASSWORD_DEFAULT);

    // 3. Update user's password
    $update = $conn->prepare("UPDATE users SET password = ?, is_temp_password = 1 WHERE id = ?");
    $update->bind_param("si", $newPasswordHashed, $user_id);
    
    if ($update->execute()) {
        $response = [
            'success' => true,
            'message' => "Temporary password is: $newPasswordPlain"
        ];
    } else {
        $response['message'] = "Failed to reset password.";
    }

    $update->close();
    $conn->close();
    echo json_encode($response);
}
