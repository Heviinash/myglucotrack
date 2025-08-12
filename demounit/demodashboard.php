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
        
        'demosidebar.php';
    
    ?>


    <!-- Main Content -->
<main class="flex-1 p-6 mt-12 md:mt-0">

    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded mb-4">
        ⚠️ This is a demo view. Form is non-functional. No data will be saved.
    </div>

    <h2 class="text-3xl font-semibold mb-4">Welcome, Guest User!</h2>
    <p class="text-gray-700">This is a <strong>Demo Role</strong> dashboard for <strong>Demo Clinic</strong>.</p>

    <div class="mt-6 p-4 bg-white shadow rounded-md">
        <h3 class="text-xl font-semibold mb-4">Add Blood Sugar Entry (Demo View)</h3>

        <!-- Demo Form Display -->
        <div class="space-y-4">

            <!-- Patient Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Patient Name</label>
                <select class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
                    <option>John Doe</option>
                    <option>Jane Smith</option>
                    <option>Demo Patient</option>
                </select>
            </div>

            <!-- Blood Sugar Level -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Blood Sugar Level (mg/dL)</label>
                <input type="number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
            </div>

            <!-- Before or After -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Before or After Meal</label>
                <select  class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
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
                <label class="block text-sm font-medium text-gray-700">Measurement Date</label>
                <input type="date"  value="<?= date('Y-m-d') ?>" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
            </div>

            <!-- Measurement Time -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Measurement Time</label>
                <input type="time"  value="<?= date('H:i') ?>" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <input type="text"  value="Sample note" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
            </div>

            <!-- Submit (disabled) -->
            <div>
                <button type="button" disabled class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">Submit (Disabled)</button>
            </div>
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
