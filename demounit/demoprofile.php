<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - GlucoTracker (Demo)</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar (Demo only) -->
    <?php include 
        
        'demosidebar.php';
    
    ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow border border-gray-200">
            <h1 class="text-2xl font-semibold text-indigo-700 mb-6 text-center">👤 My Profile </h1>

            <div class="grid grid-cols-1 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded shadow">
                    <p><strong>Full Name:</strong> John Doe</p>
                    <p><strong>Username:</strong> johndoe</p>
                    <p><strong>Role:</strong> Admin</p>
                    <p><strong>Status:</strong> Active</p>
                </div>
            </div>

            <hr class="my-6">

            <h2 class="text-xl font-semibold text-indigo-700 mb-4">🔒 Change Password</h2>

            <!-- Optional fake alert box -->
            <div class="mb-4 px-4 py-2 rounded text-white text-center text-sm font-medium bg-green-500">
                Password changed successfully!
            </div>

            <!-- Demo Form -->
            <form method="#" class="space-y-4">
                <div>
                    <label for="current_password" class="block text-gray-700 font-medium">Current Password</label>
                    <input type="password" id="current_password" required
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
                </div>

                <div>
                    <label for="new_password" class="block text-gray-700 font-medium">New Password</label>
                    <input type="password" id="new_password" required
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
                </div>

                <div>
                    <label for="confirm_password" class="block text-gray-700 font-medium">Confirm New Password</label>
                    <input type="password" id="confirm_password" required
                           class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400" />
                </div>

                <button type="button"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold">
                    🔄 Update Password
                </button>
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
