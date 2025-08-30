<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'System God') {
    header("Location: ../auth/login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

require '../config/db.php';

// Fetch session logs with JOINs
$logs = [];
$sql = "
    SELECT 
        s.id,
        u.username,
        u.fullname,
        t.tenant_name,
        s.device_info,
        s.ip_address,
        s.login_time,
        s.logout_time,
        s.still_active
    FROM sessions_log s
    JOIN users u ON s.user_id = u.id
    JOIN tenants t ON s.tenant_id = t.id
    ORDER BY s.login_time DESC
";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Logs - MyGlucoTrack</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

<?php include '../components/sidebar.php'; ?>

<main class="flex-1 p-6 mt-12 md:mt-0">
    <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
    <p class="text-gray-700">Here are the latest user session logs.</p>

    <div class="mt-6 p-4 bg-white shadow rounded-md">
        <h3 class="text-xl font-semibold mb-4">User Session Log</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border border-gray-300 text-sm">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="p-3 text-left">Tenant</th>
                        <th class="p-3 text-left">Username</th>
                        <th class="p-3 text-left">Full Name</th>
                        <th class="p-3 text-left">Device</th>
                        <th class="p-3 text-left">IP Address</th>
                        <th class="p-3 text-left">Login Time</th>
                        <th class="p-3 text-left">Logout Time</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="8" class="p-3 text-center text-gray-500">No session logs found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td class="p-3"><?= htmlspecialchars($log['tenant_name']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($log['username']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($log['fullname']) ?></td>
                                <td class="p-3 truncate max-w-xs"><?= htmlspecialchars($log['device_info']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($log['ip_address']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($log['login_time']) ?></td>
                                <td class="p-3">
                                    <?= $log['logout_time'] ? htmlspecialchars($log['logout_time']) : '<span class="text-green-600 font-medium">Still Active</span>' ?>
                                </td>
                                <td class="p-3">
                                    <?php if ($log['still_active']): ?>
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Active</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs bg-gray-200 text-gray-700 rounded-full">Logged Out</span>
                                    <?php endif; ?>
                                </td>


                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>



</body>
</html>
