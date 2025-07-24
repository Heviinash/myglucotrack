<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?, is_temp_password = 0 WHERE id = ?");
        $stmt->bind_param("si", $hashed, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = "Password changed successfully.";
        header("Location: ../dashboard.php");
        exit();
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-6 rounded shadow w-full max-w-sm space-y-4">
        <h2 class="text-xl font-bold text-center">Change Temporary Password</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-600 text-sm"><?= $error ?></p>
        <?php endif; ?>

        <div>
            <label class="block text-sm font-medium">New Password</label>
            <input type="password" name="new_password" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="confirm_password" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Change Password</button>
    </form>
</body>
</html>
