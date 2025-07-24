<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}





$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];
$tenant_id = $_SESSION['tenant_id'];


require 'config/db.php';

$tenant_name = '';
$tenantStmt = $conn->prepare("SELECT tenant_name FROM tenants WHERE id = ?");
$tenantStmt->bind_param("i", $tenant_id);
$tenantStmt->execute();
$tenantStmt->bind_result($tenant_name);
$tenantStmt->fetch();
$tenantStmt->close();


if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];



// Fetch patient names for dropdown
$stmt = $conn->prepare("SELECT patient_name FROM patient WHERE tenant_id = ? ORDER BY patient_name ASC");
$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row['patient_name'];
}
$stmt->close();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) 
    {
        die("Invalid CSRF token");
    }


    $patient_name = trim($_POST['patient_name']);
    $blood_sugar_level = trim($_POST['blood_sugar_level']);
    $before_after = trim($_POST['before_after']);
    $measurement_date = $_POST['measurement_date'];
    $measurement_time = $_POST['measurement_time'];
    $measurement_by = $_POST['measurement_by'];
    $notes = $_POST['notes'];
    $systemdatetime = date('Y-m-d H:i:s'); // current timestamp

    // Basic validation
    if (!$patient_name || !$blood_sugar_level || !$before_after || !$measurement_date || !$measurement_time) {
        die("All fields are required.");
    }

   $stmt = $conn->prepare("INSERT INTO bloodsugarlevel (
            patient_name, blood_sugar_level, before_after, measurement_time, measurement_date, measurement_by, notes, systemdatetime, tenant_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssssssi", $patient_name, $blood_sugar_level, $before_after, $measurement_time, $measurement_date, $measurement_by, $notes, $systemdatetime, $tenant_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Blood sugar record added successfully.";
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
    }




    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    unset($_SESSION['csrf_token']);

    exit();
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include 
        
        'components/sidebar.php';
    
    ?>


    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">

        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                <?= $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        
        <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
        <p class="text-gray-700">This is your <?= htmlspecialchars($role) ?> dashboard for <strong><?= htmlspecialchars($tenant_name) ?></strong>.</p>
        
        <!-- Sample dashboard content box -->
        <div class="mt-6 p-4 bg-white shadow rounded-md">
            
            <h3 class="text-xl font-semibold mb-4">Add Blood Sugar Entry</h3>

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="space-y-4">

                <!-- Patient Name Dropdown -->
                <div>
                    <label for="patient_name" class="block text-sm font-medium text-gray-700">Patient Name</label>
                    <select name="patient_name" id="patient_name" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Patient --</option>
                        <?php foreach ($patients as $name): ?>
                            <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Blood Sugar Level -->
                <div>
                    <label for="blood_sugar_level" class="block text-sm font-medium text-gray-700">Blood Sugar Level (mg/dL)</label>
                    <input type="number" step="0.1" name="blood_sugar_level" id="blood_sugar_level" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Before/After -->
                <div>
                    <label for="before_after" class="block text-sm font-medium text-gray-700">Before or After Meal</label>
                    <select name="before_after" id="before_after" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="">-- Select Before/After --</option>
                        <option value="Before Breakfast">Before Breakfast</option>
                        <option value="After Breakfast">After Breakfast</option>
                        <option value="Before Lunch">Before Lunch</option>
                        <option value="After Lunch">After Lunch</option>
                        <option value="Before Tea">Before Tea</option>
                        <option value="After Tea">After Tea</option>
                        <option value="Before Dinner">Before Dinner</option>
                        <option value="After Dinner">After Dinner</option>
                    </select>
                </div>

                <!-- Measurement Date -->
                <div>
                    <label for="measurement_date" class="block text-sm font-medium text-gray-700">Measurement Date</label>
                    <input type="date" name="measurement_date" id="measurement_date" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>

                <!-- Measurement Time -->
                <div>
                    <label for="measurement_time" class="block text-sm font-medium text-gray-700">Measurement Time</label>
                    <input type="time" name="measurement_time" id="measurement_time" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <input type="text" name="notes" id="notes" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>


                <!-- Hidden measurement_by (from session) -->
                <input type="hidden" name="measurement_by" value="<?= htmlspecialchars($fullname) ?>">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">


                <!-- Submit -->
                <div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
                </div>
            </form>






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
