<?php


session_start();

$tenant_id = $_SESSION['tenant_id'];
$adminId = $_SESSION['user_id'];



require '../config/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin' ) {
    header("Location: ../auth/login.php");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $password_raw = $_POST['password'];

    // Validation: Empty fields
    if (empty($fullname) || empty($username) || empty($password_raw)) {
        $message = "❌ All fields are required.";
    }
    // Validation: Password length
    elseif (strlen($password_raw) < 6) {
        $message = "❌ Password must be at least 6 characters.";
    }
    else {
        // Check for duplicate username
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "❌ Username already exists. Please choose another.";
        } else {
            // Proceed with registration
            $password = password_hash($password_raw, PASSWORD_DEFAULT);
            $role = 'User';
            $status = 'Active';
            $tenant_id = $_SESSION['tenant_id'];

            $stmt = $conn->prepare("INSERT INTO users (fullname, username, password, role, status, tenant_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $fullname, $username, $password, $role, $status, $tenant_id);

            if ($stmt->execute()) {
                $message = "✅ User created successfully.";
            } else {
                $message = "❌ Failed to create user.";
            }

            $stmt->close();
        }

        $checkStmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New User - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar Include -->
    <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h1 class="text-2xl font-semibold text-indigo-700 mb-6 text-center">👤 Register New User</h1>

            <?php if ($message): ?>
                <div class="mb-4 text-sm text-center font-medium text-white px-4 py-2 rounded 
                    <?= strpos($message, '✅') !== false ? 'bg-green-500' : 'bg-red-500' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="fullname" class="block text-gray-700 font-medium">Full Name</label>
                    <input type="text" name="fullname" id="fullname" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div>
                    <label for="username" class="block text-gray-700 font-medium">Username</label>
                    <input type="text" name="username" id="username" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    <input type="password" name="password" id="password" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold transition">
                        ➕ Create User
                    </button>
                </div>
            </form>



        </div>


        <?php
// Fetch all users under this tenant (admin's company)
$tenant_id = $_SESSION['tenant_id'];
$usersStmt = $conn->prepare("SELECT id, fullname, username, created_at FROM users WHERE tenant_id = ? AND id != ?");
$usersStmt->bind_param("ii", $tenant_id, $adminId);

$usersStmt->execute();
$usersResult = $usersStmt->get_result();
?>

<h2 class="text-xl font-semibold mt-10 mb-4">👥 Registered Users Under You</h2>

<div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
    <table class="min-w-full text-sm text-left">
        <thead class="bg-indigo-100 text-indigo-700 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Full Name</th>
                <th class="px-4 py-3">Username</th>
                <th class="px-4 py-3">Created At</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php while ($user = $usersResult->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3"><?= htmlspecialchars($user['fullname']) ?></td>
                <td class="px-4 py-3"><?= htmlspecialchars($user['username']) ?></td>
                <td class="px-4 py-3"><?= date("d M Y, h:i A", strtotime($user['created_at'])) ?></td>
                <td class="px-4 py-3">
                    <button onclick="confirmResetPassword(<?= $user['id'] ?>)"
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                        Reset Password
                    </button>


                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php $usersStmt->close(); ?>



    </main>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmResetPassword(userId) {
    console.log("Clicked user ID:", userId); // Debug

    Swal.fire({
        title: '🔐 Admin Password Required',
        input: 'password',
        inputLabel: 'Enter your password to confirm reset',
        inputAttributes: {
            autocapitalize: 'off',
            autocomplete: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirm Reset',
        preConfirm: (adminPassword) => {
            if (!adminPassword) {
                Swal.showValidationMessage('Password is required');
                return;
            }

            return fetch('admin_reset_user_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `user_id=${userId}&admin_password=${encodeURIComponent(adminPassword)}`
            })
            .then(response => response.json())
            .catch(() => {
                Swal.showValidationMessage('❌ Request failed. Try again.');
            });
        }
    }).then(result => {
        if (result.isConfirmed && result.value) {
            if (result.value.success) {
                Swal.fire('✅ Success', result.value.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('❌ Error', result.value.message, 'error');
            }
        }
    });
}
</script>

    <script>
        const toggleBtn = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('-translate-x-full');
        });
    </script>


</body>
</html>
