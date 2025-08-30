<?php
session_start();
require '../config/db.php';

$flash_message = null;
if (isset($_SESSION['flash_message'])) {
    $flash_message = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']); // remove after showing once
}

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "All fields are required.";
        $messageType = 'error';
    } elseif ($username === 'guest' && $password === 'guest') {
        header("Location: ../demounit/demodashboard.php");
        exit();
    } else {
        // ✅ Join with tenants to get tenant_name
        $stmt = $conn->prepare("
            SELECT u.id, u.fullname, u.password, u.role, u.status, 
                   u.is_temp_password, u.tenant_id, u.username, t.tenant_name
            FROM users u
            JOIN tenants t ON u.tenant_id = t.id
            WHERE u.username = ?
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $fullname, $hashedPassword, $role, $status, $is_temp_password, $tenant_id, $usernameDB, $tenant_name);
            $stmt->fetch();

            if ($status !== 'Active') {
                $message = "Account is on hold by Admin. Please contact Admin.";
                $messageType = 'error';
            } elseif (password_verify($password, $hashedPassword)) {
                // ✅ Set session variables
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $usernameDB;
                $_SESSION['fullname'] = $fullname;
                $_SESSION['role'] = $role;
                $_SESSION['tenant_id'] = $tenant_id;
                $_SESSION['tenant_name'] = $tenant_name;

                // ✅ Collect device + IP info
                $device = $_SERVER['HTTP_USER_AGENT'];
                $ip = $_SERVER['REMOTE_ADDR'];

                // ✅ Insert into sessions_log
                $stmtLog = $conn->prepare("
                    INSERT INTO sessions_log (user_id, tenant_id, device_info, ip_address, login_time, still_active)
                    VALUES (?, ?, ?, ?, NOW(), 1)
                ");
                $stmtLog->bind_param("iiss", $id, $tenant_id, $device, $ip);
                $stmtLog->execute();

                $_SESSION['session_log_id'] = $stmtLog->insert_id;
                $stmtLog->close();

                // ✅ Redirect
                if ($is_temp_password == 1) {
                    $_SESSION['is_temp_password'] = 1;
                    header("Location: ../modules/change_password.php");
                    exit();
                } else {
                    $_SESSION['is_temp_password'] = 0;
                    header("Location: ../dashboard.php");
                    exit();
                }

            } else {
                $message = "Incorrect password.";
                $messageType = 'error';
            }
        } else {
            $message = "User not found.";
            $messageType = 'error';
        }

        $stmt->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-900 to-blue-400 min-h-screen flex items-center justify-center px-4">

    <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md space-y-6 animate-fade-in-down">

        <?php if ($flash_message): ?>
            <div id="flash-message" class="mb-4 rounded-xl bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm shadow-md">
                <?= htmlspecialchars($flash_message) ?>
            </div>
        <?php endif; ?>

        



        <div class="text-center">
            <h2 class="text-3xl font-bold text-blue-800">MyGlucoTrack</h2>
            <p class="text-sm text-gray-500 mt-1">Login to your account</p>
        </div>

        <!-- ✅ Message Area -->
        <?php if (!empty($message)): ?>
            <div class="px-4 py-3 rounded text-sm <?= $messageType === 'error' ? 'bg-red-100 text-red-800 border border-red-400' : 'bg-green-100 text-green-800 border border-green-400' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- ✅ Form -->
        <form method="POST" class="space-y-4">
            <div>
                <label class="block mb-1 font-medium">Username</label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded transition duration-200">
                Login
            </button>

            <p class="text-sm text-center mt-4 text-gray-600">
                Don't have an account?
                <a href="registration.php" class="text-blue-700 font-medium hover:underline">Register here</a>
            </p>
        </form>

        <p class="text-xs text-gray-400 text-center">© <?= date('Y') ?> GlucoTracker. All rights reserved.</p>
    </div>

    <style>
        @keyframes fade-in-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fade-in-down 0.5s ease-out;
        }
    </style>

</body>

<script>
    setTimeout(() => {
        const alert = document.getElementById("flash-message");
        if (alert) {
            alert.style.transition = "opacity 0.5s";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000); // disappears after 4s
</script>

</html>
