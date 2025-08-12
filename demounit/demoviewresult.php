<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results - GlucoTracker (Demo)</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include 'demosidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">

        <h2 class="text-3xl font-semibold mb-4">Welcome, <?= htmlspecialchars($fullname) ?>!</h2>
        <p class="text-gray-700">This is your <?= htmlspecialchars($role) ?> dashboard (Demo Mode).</p>

        <div class="mt-6 p-4 bg-white shadow rounded-md">

        <h3 class="text-xl font-semibold mb-4">Sample Blood Sugar Records (Demo)</h3>

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
                    </tr>
                </thead>
                <tbody class="bg-white text-gray-700">
                    <tr class="border-t">
                        <td class="px-4 py-2 border">John Doe</td>
                        <td class="px-4 py-2 border">112</td>
                        <td class="px-4 py-2 border">Before Breakfast</td>
                        <td class="px-4 py-2 border">07:30</td>
                        <td class="px-4 py-2 border">2025-07-23</td>
                        <td class="px-4 py-2 border">Nurse A</td>
                        <td class="px-4 py-2 border">2025-07-23 07:32:11</td>
                        <td class="px-4 py-2 border">Fasting check</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-2 border">Jane Smith</td>
                        <td class="px-4 py-2 border">145</td>
                        <td class="px-4 py-2 border">After Lunch</td>
                        <td class="px-4 py-2 border">13:45</td>
                        <td class="px-4 py-2 border">2025-07-22</td>
                        <td class="px-4 py-2 border">Nurse B</td>
                        <td class="px-4 py-2 border">2025-07-22 13:46:55</td>
                        <td class="px-4 py-2 border">Mild fatigue</td>
                    </tr>
                    <tr class="border-t">
                        <td class="px-4 py-2 border">Alice Kumar</td>
                        <td class="px-4 py-2 border">90</td>
                        <td class="px-4 py-2 border">Before Dinner</td>
                        <td class="px-4 py-2 border">18:15</td>
                        <td class="px-4 py-2 border">2025-07-21</td>
                        <td class="px-4 py-2 border">Dr. K</td>
                        <td class="px-4 py-2 border">2025-07-21 18:16:30</td>
                        <td class="px-4 py-2 border">Stable</td>
                    </tr>
                </tbody>
            </table>
        </div>

        </div>
    </main>

</body>
</html>
