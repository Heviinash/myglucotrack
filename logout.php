<?php
session_start();
require_once "config/db.php";

// update logout_time + still_active
if (isset($_SESSION['session_log_id'])) {
    $session_log_id = $_SESSION['session_log_id'];
    $stmt = $conn->prepare("UPDATE sessions_log SET logout_time = NOW(), still_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $session_log_id);
    $stmt->execute();
}

// destroy session
session_unset();
session_destroy();

// start a new session for flash message
session_start();
$_SESSION['flash_message'] = "You have logged out successfully.";


header("Location: auth/login.php");
exit();

?>