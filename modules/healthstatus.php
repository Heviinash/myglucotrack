<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require '../config/db.php';

$fullname = $_SESSION['fullname'];
$role = $_SESSION['role'];

function getStatus($timing, $level) {
    $timing = strtolower($timing);
    if (strpos($timing, 'before') !== false) {
        if ($level < 5.6) return ['Normal', 'green'];
        elseif ($level < 7.0) return ['Pre-Diabetic', 'yellow'];
        else return ['Diabetic', 'red'];
    } else {
        if ($level < 7.8) return ['Normal', 'green'];
        elseif ($level < 11.1) return ['Pre-Diabetic', 'yellow'];
        else return ['Diabetic', 'red'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Sugar Summary - GlucoTracker</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar -->
    <?php include '../components/sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <h2 class="text-3xl font-semibold mb-2">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
        <p class="text-gray-700 mb-6">Role: <?= htmlspecialchars($role) ?></p>

        <h1 class="text-4xl font-bold text-indigo-700 mb-8 text-center">🩸 Blood Sugar Health Summary</h1>

        <?php
        $tenantId = $_SESSION['tenant_id'];
        $stmt = $conn->prepare("SELECT DISTINCT patient_name, age FROM patient WHERE tenant_id = ?");
        $stmt->bind_param("i", $tenantId);
        $stmt->execute();
        $patients = $stmt->get_result();


        if ($patients && $patients->num_rows > 0):
            while ($patient = $patients->fetch_assoc()):
                $name = $patient['patient_name'];
                $age = $patient['age'];

                // Fetch grouped averages
                $stmt = $conn->prepare("
                    SELECT before_after, ROUND(AVG(blood_sugar_level), 2) AS avg_level
                    FROM bloodsugarlevel
                    WHERE patient_name = ?
                    GROUP BY before_after
                ");
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $result = $stmt->get_result();

                $status_counts = ['Normal' => 0, 'Pre-Diabetic' => 0, 'Diabetic' => 0];
        ?>

        <div class="bg-white p-6 rounded-xl shadow mb-8 border border-gray-200">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">
                    🧍 <span class="text-indigo-600"><?= htmlspecialchars($name) ?></span>
                    <span class="text-sm text-gray-500">(Age: <?= $age ?>)</span>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-300 rounded-lg">
                    <thead class="bg-indigo-100 text-indigo-700 uppercase font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">Timing</th>
                            <th class="px-4 py-2 text-left">Avg Sugar (mmol/L)</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-gray-700">
                        <?php while ($row = $result->fetch_assoc()): 
                            $timing = $row['before_after'];
                            $avg = $row['avg_level'];
                            [$status, $color] = getStatus($timing, $avg);
                            $status_counts[$status]++;

                            $badgeColor = match ($color) {
                                'green' => 'bg-green-100 text-green-700',
                                'yellow' => 'bg-yellow-100 text-yellow-700',
                                'red' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border-t"><?= htmlspecialchars($timing) ?></td>
                            <td class="px-4 py-2 border-t"><?= $avg ?></td>
                            <td class="px-4 py-2 border-t">
                                <span class="px-3 py-1 rounded-full text-sm font-medium <?= $badgeColor ?>">
                                    <?= $status ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <?php
                arsort($status_counts);
                $final_status_text = array_key_first($status_counts);

                $finalBadge = match ($final_status_text) {
                    'Normal' => 'bg-green-100 text-green-700',
                    'Pre-Diabetic' => 'bg-yellow-100 text-yellow-700',
                    'Diabetic' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-700'
                };
            ?>

            <div class="mt-6 p-4 bg-gray-50 border border-dashed border-gray-300 rounded text-lg font-semibold">
                🩺 Overall Status:
                <span class="ml-2 px-4 py-1 rounded-full <?= $finalBadge ?>">
                    <?= $final_status_text ?>
                </span>
            </div>
        </div>

        <?php
            endwhile;
        else:
        ?>
            <p class="text-gray-500 text-center mt-10">No patients found.</p>
        <?php endif; ?>
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
