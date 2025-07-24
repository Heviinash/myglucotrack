<?php
session_start();
require '../config/db.php';

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$message = '';
$success = false;

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $message = "❌ All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "❌ New passwords do not match.";
    } elseif (strlen($newPassword) < 6) {
        $message = "❌ New password must be at least 6 characters.";
    } else {
        // Get existing hashed password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        // Verify current password
        if (!password_verify($currentPassword, $hashedPassword)) {
            $message = "❌ Current password is incorrect.";
        } else {
            // Update password
            $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $newHashed, $userId);

            if ($stmt->execute()) {
                $message = "✅ Password updated successfully.";
                $success = true;
            } else {
                $message = "❌ Failed to update password.";
            }
            $stmt->close();
        }
    }
}

// Fetch user info
$stmt = $conn->prepare("SELECT fullname, username, role, status FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($fullname, $username, $role, $status);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

<!-- Sidebar Include -->
<?php include '../components/sidebar.php'; ?>

<!-- Main Content -->
<main class="flex-1 p-6 mt-12 md:mt-0">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow border border-gray-200">
        <h1 class="text-2xl font-semibold text-indigo-700 mb-6 text-center">👤 My Profile</h1>

        <div class="grid grid-cols-1 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded shadow">
                <p><strong>Full Name:</strong> <?= htmlspecialchars($fullname) ?></p>
                <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($role) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($status) ?></p>
            </div>
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-semibold text-indigo-700 mb-4">🔒 Change Password</h2>

        <?php if ($message): ?>
            <div class="mb-4 px-4 py-2 rounded text-white text-center text-sm font-medium 
                <?= $success ? 'bg-green-500' : 'bg-red-500' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label for="current_password" class="block text-gray-700 font-medium">Current Password</label>
                <input type="password" name="current_password" id="current_password" required
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
            </div>

            <div>
                <label for="new_password" class="block text-gray-700 font-medium">New Password</label>
                <input type="password" name="new_password" id="new_password" required
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
            </div>

            <div>
                <label for="confirm_password" class="block text-gray-700 font-medium">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                       class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold">
                🔄 Update Password
            </button>
        </form>
    </div>
</main>

    <script>
        const toggleBtn = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('-translate-x-full');
        });
    </script>


</body>
</html>
