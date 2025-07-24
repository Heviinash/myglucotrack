<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];


require '../config/db.php';

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch all records from bloodsugarlevel
// Fetch all records from bloodsugarlevel
$filters = [];
$params = [];
$types = '';

$filters[] = "tenant_id = ?";
$params[] = $_SESSION['tenant_id'];
$types .= "i";


if (!empty($_GET['patient_name'])) {
    $filters[] = "patient_name = ?";
    $params[] = $_GET['patient_name'];
    $types .= "s";
}

if (!empty($_GET['measurement_date'])) {
    $filters[] = "measurement_date = ?";
    $params[] = $_GET['measurement_date'];
    $types .= "s";
}

if (!empty($_GET['measurement_time'])) {
    $filters[] = "measurement_time = ?";
    $params[] = $_GET['measurement_time'];
    $types .= "s";
}

$sql = "SELECT * FROM bloodsugarlevel";
if (!empty($filters)) {
    $sql .= " WHERE " . implode(" AND ", $filters);
}
$sql .= " ORDER BY systemdatetime DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

     <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
        <p class="text-gray-700">This is your <?= htmlspecialchars($role) ?> dashboard.</p>

        <!-- Sample dashboard content box -->
        <div class="mt-6 p-4 bg-white shadow rounded-md">

        <h3 class="text-xl font-semibold mb-4">Blood Sugar Records</h3>


        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
    <!-- Patient Name Filter -->
    <div>
        <label class="block text-sm font-medium mb-1" for="patient_name">Patient Name</label>
        <select name="patient_name" id="patient_name" class="px-3 py-2 border rounded w-48">
            <option value="">All</option>
            <?php
            $patientStmt = $conn->prepare("SELECT DISTINCT patient_name FROM bloodsugarlevel WHERE tenant_id = ? ORDER BY patient_name ASC");
            $patientStmt->bind_param("i", $_SESSION['tenant_id']);
            $patientStmt->execute();
            $patientNames = $patientStmt->get_result();

            while ($pn = $patientNames->fetch_assoc()):
            ?>
                <option value="<?= $pn['patient_name'] ?>" <?= isset($_GET['patient_name']) && $_GET['patient_name'] === $pn['patient_name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($pn['patient_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <!-- Date Filter -->
    <div>
        <label class="block text-sm font-medium mb-1" for="measurement_date">Measurement Date</label>
        <input type="date" name="measurement_date" id="measurement_date" class="px-3 py-2 border rounded w-48"
               value="<?= isset($_GET['measurement_date']) ? $_GET['measurement_date'] : '' ?>">
    </div>

    <!-- Time Filter -->
    <div>
        <label class="block text-sm font-medium mb-1" for="measurement_time">Measurement Time</label>
        <input type="time" name="measurement_time" id="measurement_time" class="px-3 py-2 border rounded w-48"
               value="<?= isset($_GET['measurement_time']) ? $_GET['measurement_time'] : '' ?>">
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        <a href="viewresults.php" class="ml-2 text-sm underline text-blue-700">Reset</a>
    </div>
</form>


<div class="overflow-x-auto">
    <table class="min-w-full table-auto text-sm border border-gray-300">
        <thead class="bg-blue-100 text-gray-800 font-semibold">
            <tr>
                <th class="px-4 py-2 border">Patient Name</th>
                <th class="px-4 py-2 border">Blood Sugar (mg/dL)</th>
                <th class="px-4 py-2 border">Before/After</th>
                <th class="px-4 py-2 border">Measurement Time</th>
                <th class="px-4 py-2 border">Measurement Date</th>
                <th class="px-4 py-2 border">Measured By</th>
                <th class="px-4 py-2 border">System Datetime</th>
                <th class="px-4 py-2 border">Notes</th>
                <?php if ($role === 'System God' || $role === 'Admin'): ?>
                    <th class="px-4 py-2 border">Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="bg-white text-gray-700">
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['patient_name']) ?></td>
                    <td class="px-4 py-2 border">
                        <?php if ($role === 'System God' || $role === 'Admin'): ?>
                            <form action="update_bloodsugar.php" method="POST" class="flex gap-2 items-center">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <input type="number" step="0.1" name="blood_sugar_level" value="<?= $row['blood_sugar_level'] ?>" class="w-20 px-2 py-1 border border-gray-300 rounded" required>
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 text-xs">Update</button>
                            </form>
                        <?php else: ?>
                            <?= htmlspecialchars($row['blood_sugar_level']) ?>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['before_after']) ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['measurement_time']) ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['measurement_date']) ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['measurement_by']) ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['systemdatetime']) ?></td>
                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['notes']) ?></td>
                    <?php if ($role === 'System God' || $role === 'Admin'): ?>
    <td class="px-4 py-2 border text-center space-y-1">
        <form action="delete_bloodsugar.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs w-full">Delete</button>
        </form>

    </td>
<?php endif; ?>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

        </div>
    </main>

    <!-- JS for Mobile Menu -->
    <script>
        const toggleBtn = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('-translate-x-full');
        });
    </script>

</body>
</html>
