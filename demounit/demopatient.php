<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient - GlucoTracker (Demo)</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <?php include 
        
        'demosidebar.php';
    
    ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <h2 class="text-3xl font-semibold mb-4">Welcome, John Doe!</h2>
        <p class="text-gray-700 mb-4">Role: Admin</p>

        <!-- Patient form -->
        <div class="p-6 bg-white rounded-md shadow-md max-w-xl">
            <h3 class="text-xl font-semibold mb-4">Add New Patient (Demo)</h3>

            <!-- Demo form (no submission) -->
            <form action="#" method="POST" class="space-y-4">
                <div>
                    <label for="patient_name" class="block font-medium mb-1">Patient Name:</label>
                    <input type="text" name="patient_name" id="patient_name" class="w-full px-4 py-2 border rounded-md" placeholder="Enter patient name">
                </div>
                <div>
                    <label for="age" class="block font-medium mb-1">Age:</label>
                    <input type="number" name="age" id="age" class="w-full px-4 py-2 border rounded-md" placeholder="Age">
                </div>
                <button type="button" class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded">
                    Submit (Demo)
                </button>
            </form>

            <!-- Static patient list -->
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
                        <tr class="border-t">
                            <td class="px-4 py-2 border">Jane Smith</td>
                            <td class="px-4 py-2 border">45</td>
                            <td class="px-4 py-2 border text-center">
                                <button type="button" onclick="openConfirmModal(1)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 border">Rahul Kumar</td>
                            <td class="px-4 py-2 border">32</td>
                            <td class="px-4 py-2 border text-center">
                                <button type="button" onclick="openConfirmModal(2)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 border">Aisha Tan</td>
                            <td class="px-4 py-2 border">28</td>
                            <td class="px-4 py-2 border text-center">
                                <button type="button" onclick="openConfirmModal(3)" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Confirm Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 w-80">
            <h2 class="text-lg font-semibold mb-4 text-center">Confirm Deletion</h2>
            <p class="text-sm text-gray-600 mb-6 text-center">Are you sure you want to delete this patient?</p>

            <div class="flex justify-between">
                <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
                <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Yes, Delete</button>
            </div>
        </div>
    </div>

    <!-- JS for modal demo -->
    <script>
        function openConfirmModal(id) {
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
    </script>
</body>
</html>
