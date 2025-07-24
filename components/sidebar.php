<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? 'User';
$fullname = $_SESSION['fullname'] ?? 'Guest';

// Detect current directory to handle correct paths
$inModules = strpos($_SERVER['PHP_SELF'], '/modules/') !== false;
$prefix = $inModules ? '../' : '';
?>

<!-- Desktop Sidebar -->
<aside class="w-64 bg-blue-900 text-white flex-shrink-0 hidden md:block">
    <div class="p-6 text-center border-b border-blue-700">
        <h1 class="text-2xl font-bold">GlucoTracker</h1>
        <p class="text-sm mt-2"><?= htmlspecialchars($role) ?></p>
    </div>
    <nav class="mt-6 space-y-2 px-4">
        <a href="<?= $prefix ?>dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard</a>
        <a href="<?= $prefix ?>modules/profile.php" class="block py-2 px-4 rounded hover:bg-blue-700">Profile</a>

        <?php if ($role === 'System God'): ?>
            <a href="<?= $prefix ?>modules/usercontrol.php" class="block py-2 px-4 rounded hover:bg-blue-700">User Control</a>
            <a href="<?= $prefix ?>modules/patient.php" class="block py-2 px-4 rounded hover:bg-blue-700">Patient</a>
        <?php elseif ($role === 'Admin'): ?>
            <a href="<?= $prefix ?>modules/patient.php" class="block py-2 px-4 rounded hover:bg-blue-700">Patient</a>
            <a href="<?= $prefix ?>modules/register_user.php" class="block py-2 px-4 rounded hover:bg-blue-700">Create Users</a>
            
        <?php endif; ?>
        
        <a href="<?= $prefix ?>modules/healthstatus.php" class="block py-2 px-4 rounded hover:bg-blue-700">Health Status</a>
        <a href="<?= $prefix ?>modules/viewresults.php" class="block py-2 px-4 rounded hover:bg-blue-700">View Result</a>
        <a href="<?= $prefix ?>logout.php" class="block py-2 px-4 rounded hover:bg-red-600 mt-6">Logout</a>
    </nav>
</aside>

<!-- Mobile Top Nav -->
<div class="md:hidden p-4 fixed top-0 left-0 w-full bg-blue-900 text-white flex justify-start items-center z-50">
    <button id="menuToggle" class="focus:outline-none mr-4">☰</button>
    <span class="font-bold text-lg">GlucoTracker</span>
</div>

<!-- Mobile Sidebar -->
<div id="mobileMenu" class="fixed inset-y-0 left-0 w-64 bg-blue-900 text-white p-6 transform -translate-x-full transition-transform duration-200 z-40 md:hidden">
    <h1 class="text-xl font-bold mb-6">Menu</h1>
    <nav class="space-y-4">
        <a href="<?= $prefix ?>dashboard.php" class="block py-2 px-4 rounded hover:bg-blue-700">Dashboard</a>
        <a href="<?= $prefix ?>modules/profile.php" class="block py-2 px-4 rounded hover:bg-blue-700">Profile</a>

        <?php if ($role === 'System God'): ?>
            <a href="<?= $prefix ?>modules/usercontrol.php" class="block py-2 px-4 rounded hover:bg-blue-700">User Control</a>
            <a href="<?= $prefix ?>modules/patient.php" class="block py-2 px-4 rounded hover:bg-blue-700">Patient</a>
        <?php elseif ($role === 'Admin'): ?>
            <a href="<?= $prefix ?>modules/patient.php" class="block py-2 px-4 rounded hover:bg-blue-700">Patient</a>
            <a href="<?= $prefix ?>modules/register_user.php" class="block py-2 px-4 rounded hover:bg-blue-700">Create Users</a>
            
            
        <?php endif; ?>

        <a href="<?= $prefix ?>modules/healthstatus.php" class="block py-2 px-4 rounded hover:bg-blue-700">Health Status</a>
        <a href="<?= $prefix ?>modules/viewresults.php" class="block py-2 px-4 rounded hover:bg-blue-700">View Result</a>
        <a href="<?= $prefix ?>logout.php" class="block py-2 px-4 rounded hover:bg-red-600">Logout</a>
    </nav>
</div>
