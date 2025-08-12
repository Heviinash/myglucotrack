<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'System God') {
    header("Location: ../auth/login.php");
    exit();
}


$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

// Fetch all users
require '../config/db.php';
$users = [];

$sql = "
    SELECT 
        users.id, 
        users.fullname, 
        users.username, 
        users.role, 
        users.status, 
        users.tenant_id,
        tenants.tenant_name
    FROM users
    LEFT JOIN tenants ON users.tenant_id = tenants.id
    WHERE users.role = 'Admin'
    ORDER BY users.id DESC
";




$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Control - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

<?php include '../components/sidebar.php'; ?>

<main class="flex-1 p-6 mt-12 md:mt-0">
    <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
    <p class="text-gray-700">This is your <?= htmlspecialchars($role) ?> dashboard.</p>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <?= $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="mt-6 p-4 bg-white shadow rounded-md">
        <h3 class="text-xl font-semibold mb-4">Registered Users</h3>

        <form method="POST" action="update_user_role_status.php">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-300 text-sm">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="p-3 text-left">Tenant Name</th>
                            <th class="p-3 text-left">Full Name</th>
                            <th class="p-3 text-left">Username</th>
                            <th class="p-3 text-left">Role</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Password Reset</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="p-3"><?= htmlspecialchars($user['tenant_name'] ?? 'No Tenant') ?></td>
                                <td class="p-3"><?= htmlspecialchars($user['fullname']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($user['role']) ?></td>
                                <td class="p-3">
                                    <select 
                                        data-user-id="<?= $user['id'] ?>" 
                                        class="status-dropdown border rounded px-2 py-1"
                                    >
                                        <option value="Active" <?= $user['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                                        <option value="Inactive" <?= $user['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                                    </select>

                                </td>
                                <td class="p-3">
                                    <button type="button" class="bg-yellow-500 text-white px-2 py-1 rounded" onclick="confirmResetPassword(<?= $user['id'] ?>)">
                                        Reset Password
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</main>

<script>
    const toggleBtn = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    toggleBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('-translate-x-full');
    });

    function confirmResetPassword(userId) {
        Swal.fire({
            title: 'Admin Password Required',
            input: 'password',
            inputLabel: 'Enter your password to confirm',
            inputAttributes: {
                autocapitalize: 'off',
                autocomplete: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm Reset',
            preConfirm: (adminPassword) => {
                if (!adminPassword) {
                    Swal.showValidationMessage('Password is required');
                }
                return fetch('reset_password.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `user_id=${userId}&admin_password=${encodeURIComponent(adminPassword)}`
                })
                .then(response => response.json())
                .catch(() => {
                    Swal.showValidationMessage('Request failed. Try again.');
                });
            }
        }).then(result => {
            if (result.isConfirmed && result.value) {
                if (result.value.success) {
                    Swal.fire('Success', result.value.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', result.value.message, 'error');
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


<script>
document.querySelectorAll('.status-dropdown').forEach(dropdown => {
    dropdown.addEventListener('change', (e) => {
        const select = e.target;
        const userId = select.getAttribute('data-user-id');
        const newStatus = select.value;

        fetch('update_user_role_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_id=${encodeURIComponent(userId)}&status=${encodeURIComponent(newStatus)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Status updated',
                    toast: true,
                    timer: 1500,
                    position: 'top-end',
                    showConfirmButton: false,
                });
            } else {
                Swal.fire('Error', data.message || 'Update failed', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Request failed. Try again.', 'error');
        });
    });
});
</script>


</body>
</html>
