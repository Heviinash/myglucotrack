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

    <!-- Dummy Sidebar -->
    <?php include 
        
        'demosidebar.php';
    
    ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <h2 class="text-3xl font-semibold mb-2">Welcome, John Doe!</h2>
        <p class="text-gray-700 mb-6">Role: Admin</p>

        <h1 class="text-4xl font-bold text-indigo-700 mb-8 text-center">🩸 Blood Sugar Health Summary</h1>

        <!-- Dummy Patient Summary -->
        <div class="bg-white p-6 rounded-xl shadow mb-8 border border-gray-200">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">
                    🧍 <span class="text-indigo-600">Jane Smith</span>
                    <span class="text-sm text-gray-500">(Age: 45)</span>
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
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border-t">Before Breakfast</td>
                            <td class="px-4 py-2 border-t">5.4</td>
                            <td class="px-4 py-2 border-t">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                    Normal
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border-t">After Lunch</td>
                            <td class="px-4 py-2 border-t">8.2</td>
                            <td class="px-4 py-2 border-t">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                                    Pre-Diabetic
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border-t">After Dinner</td>
                            <td class="px-4 py-2 border-t">11.5</td>
                            <td class="px-4 py-2 border-t">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
                                    Diabetic
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Overall status -->
            <div class="mt-6 p-4 bg-gray-50 border border-dashed border-gray-300 rounded text-lg font-semibold">
                🩺 Overall Status:
                <span class="ml-2 px-4 py-1 rounded-full bg-yellow-100 text-yellow-700">
                    Pre-Diabetic
                </span>
            </div>
        </div>

        <!-- You can copy the above block to add more dummy patients -->

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
