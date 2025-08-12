<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New User - GlucoTracker (Demo)</title>
    <link rel="icon" type="image/png" href="/GlucoTracker/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

    <!-- Sidebar Placeholder -->
    <?php include 
        
        'demosidebar.php';
    
    ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 mt-12 md:mt-0">
        <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h1 class="text-2xl font-semibold text-indigo-700 mb-6 text-center">👤 Register New User</h1>

            <div class="mb-4 text-sm text-center font-medium text-white px-4 py-2 rounded bg-green-500">
                ✅ User created successfully (demo)
            </div>

            <form action="" method="POST" class="space-y-4">
                <div>
                    <label for="fullname" class="block text-gray-700 font-medium">Full Name</label>
                    <input type="text" id="fullname" value="John Doe" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div>
                    <label for="username" class="block text-gray-700 font-medium">Username</label>
                    <input type="text" id="username" value="john123" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    <input type="password" id="password" value="secret" required
                        class="mt-1 w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
                </div>

                <div class="pt-4">
                    <button type="button"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold transition">
                        ➕ Create User
                    </button>
                </div>
            </form>
        </div>

        <h2 class="text-xl font-semibold mt-10 mb-4">👥 Registered Users Under You (Demo)</h2>

        <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-indigo-100 text-indigo-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Full Name</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Created At</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">Alice Kumar</td>
                        <td class="px-4 py-3">alicek</td>
                        <td class="px-4 py-3">01 Jul 2025, 10:15 AM</td>
                        <td class="px-4 py-3">
                            <button onclick="confirmResetPassword(1)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Reset Password
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">Ravi Das</td>
                        <td class="px-4 py-3">ravi2025</td>
                        <td class="px-4 py-3">15 Jul 2025, 03:45 PM</td>
                        <td class="px-4 py-3">
                            <button onclick="confirmResetPassword(2)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Reset Password
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    function confirmResetPassword(userId) {
        Swal.fire({
            title: '🔐 Admin Password Required',
            input: 'password',
            inputLabel: 'Enter your password to confirm reset',
            inputAttributes: {
                autocapitalize: 'off',
                autocomplete: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm Reset',
            preConfirm: (adminPassword) => {
                if (!adminPassword) {
                    Swal.showValidationMessage('Password is required');
                    return;
                }

                // Simulated success response (demo only)
                return Promise.resolve({
                    success: true,
                    message: 'Password has been reset to: temp1234'
                });
            }
        }).then(result => {
            if (result.isConfirmed && result.value) {
                if (result.value.success) {
                    Swal.fire('✅ Success', result.value.message, 'success');
                } else {
                    Swal.fire('❌ Error', result.value.message, 'error');
                }
            }
        });
    }
    </script>

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
