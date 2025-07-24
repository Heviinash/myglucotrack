<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'System God' &&  $_SESSION['role'] !== 'Admin' ) {
    header("Location: ../auth/login.php");
    exit();
}

$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];
$tenant_id = $_SESSION['tenant_id'];

require '../config/db.php';



// Handle form submission



$insert_success = '';
if (isset($_SESSION['success'])) {
    $insert_success = $_SESSION['success'];
    unset($_SESSION['success']); // 💥 clear after showing
}

$error_msg = '';
if (isset($_SESSION['error'])) {
    $error_msg = $_SESSION['error'];
    unset($_SESSION['error']);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name = trim($_POST['patient_name']);
    $age = trim($_POST['age']);

    if (empty($patient_name) || empty($age)) {
        $error_msg = "Please fill in the required.";
    } else {
        $check = $conn->prepare("SELECT id FROM patient WHERE patient_name = ? AND age=? ");
        $check->bind_param("si", $patient_name, $age);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error_msg = "Patient name already exists.";
        } else {
           $stmt = $conn->prepare("INSERT INTO patient (patient_name, age, tenant_id) VALUES (?, ?, ?)");
           $stmt->bind_param("sii", $patient_name, $age, $tenant_id);

            if ($stmt->execute()) {
                $insert_success = "Patient created successfully!";
            } else {
                $error_msg = "Database error: " . $stmt->error;
            }
            $stmt->close();
        }

        $check->close();
    }


}

// Fetch all patients
$patients_query = "SELECT * FROM patient WHERE tenant_id = $tenant_id ORDER BY id DESC";
$patients_result = $conn->query($patients_query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

     <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
        <p class="text-gray-700 mb-4">Role: <?= htmlspecialchars($role) ?></p>

        <!-- Patient form -->
        <div class="p-6 bg-white rounded-md shadow-md max-w-xl">
            <h3 class="text-xl font-semibold mb-4">Add New Patient</h3>

            
            <?php if (!empty($insert_success)): ?>
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4"><?= $insert_success ?></div>

            <?php elseif ($error_msg): ?>
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4"><?= $error_msg ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="patient_name" class="block font-medium mb-1">Patient Name:</label>
                    <input type="text" name="patient_name" id="patient_name" class="w-full px-4 py-2 border rounded-md" placeholder="Enter patient name" required>
                </div>
                <div>
                    <label for="age" class="block font-medium mb-1">Age:</label>
                    <input type="number" name="age" id="age" class="w-full px-4 py-2 border rounded-md" placeholder="Age" required>
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded">
                    Submit
                </button>
            </form>

            <?php if ($patients_result && $patients_result->num_rows > 0): ?>
                <div class="mt-8 bg-white p-4 rounded-md shadow">
                    <h3 class="text-lg font-semibold mb-4">Patient List</h3>
                    <table class="min-w-full table-auto text-sm border border-gray-300">
                        <thead class="bg-blue-100 text-gray-800 font-semibold">
                            <tr>
                                <th class="px-4 py-2 border">Patient Name</th>
                                <th class="px-4 py-2 border">Age</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-gray-700">
                            <?php while ($row = $patients_result->fetch_assoc()): ?>
                                <tr class="border-t">
                                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['patient_name']) ?></td>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars($row['age']) ?></td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button" onclick="openConfirmModal(<?= $row['id'] ?>)"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                            Delete
                                        </button>

                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="mt-6 text-gray-500">No patients found.</p>
            <?php endif; ?>



        </div>
    </main>

    <?php

        $conn->close();

    ?>

    <!-- JS for Mobile Menu -->
    <script>
        const toggleBtn = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        toggleBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('-translate-x-full');
        });
    </script>

<!-- Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg p-6 w-80">
        <h2 class="text-lg font-semibold mb-4 text-center">Confirm Deletion</h2>
        <p class="text-sm text-gray-600 mb-6 text-center">Are you sure you want to delete this patient?</p>

        <!-- FORM starts here -->
        <form method="POST" action="delete_patient.php" id="deleteForm">
            <input type="hidden" name="id" id="deletePatientId">
            <div class="flex justify-between">
                <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>


<script>
function openConfirmModal(patientId) {
    document.getElementById('deletePatientId').value = patientId;
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}
</script>

</body>
</html>
