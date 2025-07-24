<?php
require '../config/db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenant_name = trim($_POST['tenant_name']);
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);

    if (empty($tenant_name) || empty($fullname) || empty($username) || empty($password) || empty($confirmpassword)) {
        $message = "All fields are required.";
        $messageType = 'error';
    } elseif ($password !== $confirmpassword) {
        $message = "Passwords do not match.";
        $messageType = 'error';
    } else {
        // 1. Create tenant
        $stmtTenant = $conn->prepare("INSERT INTO tenants (tenant_name) VALUES (?)");
        $stmtTenant->bind_param("s", $tenant_name);
        if ($stmtTenant->execute()) {
            $tenant_id = $stmtTenant->insert_id; // Get new tenant ID

            // 2. Check for username duplication
            $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $check->bind_param("s", $username);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $message = "Username already taken.";
                $messageType = 'error';
            } else {
                // 3. Insert admin user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $role = 'Admin';
                $status = 'Inactive';

                $stmtUser = $conn->prepare("INSERT INTO users (fullname, username, password, role, status, tenant_id) VALUES (?, ?, ?, ?, ?, ?)");
                $stmtUser->bind_param("sssssi", $fullname, $username, $hashedPassword, $role, $status, $tenant_id);

                if ($stmtUser->execute()) {
                    $message = "✅ Tenant and admin registered successfully. <a href='login.php' class='underline text-blue-700'>Login here</a>";
                    $messageType = 'success';
                } else {
                    $message = "User creation failed: " . $stmtUser->error;
                    $messageType = 'error';
                }
                $stmtUser->close();
            }
            $check->close();
        } else {
            $message = "Tenant creation failed: " . $stmtTenant->error;
            $messageType = 'error';
        }

        $stmtTenant->close();
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Admins Register to GlucoTracker</h2>

        <!-- ✅ Message Display -->
        <?php if (!empty($message)): ?>
            <div class="mb-4 px-4 py-3 rounded text-sm
                <?= $messageType === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- ✅ Registration Form -->
        <form method="POST" action="" class="space-y-4">
            <div>
                <label for="tenant_name" class="block text-sm font-medium text-gray-700">Tenant Name </label>
                <input type="text" name="tenant_name" id="tenant_name" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="fullname" class="block text-sm font-medium text-gray-700">Fullname </label>
                <input type="text" name="fullname" id="fullname" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="confirmpassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200 font-semibold">
                Register Account
            </button>

            <p class="text-sm text-center mt-4 text-gray-600">
                Already have an account?
                <a href="login.php" class="text-blue-700 font-medium hover:underline">Login here</a>
            </p>
        </form>
    </div>

</body>
</html>
