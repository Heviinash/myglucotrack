<?php
session_start();

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['System God', 'Admin'])) {
    die("Unauthorized access.");
}

require '../config/db.php';

$id = $_POST['id'] ?? null;
$blood_sugar_level = $_POST['blood_sugar_level'] ?? null;
$tenant_id = $_SESSION['tenant_id'];

if ($id && $blood_sugar_level !== null) {
    $stmt = $conn->prepare("UPDATE bloodsugarlevel SET blood_sugar_level = ? WHERE id = ? AND tenant_id = ?");
    $stmt->bind_param("dii", $blood_sugar_level, $id, $tenant_id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Blood sugar level updated successfully.";
        } else {
            $_SESSION['message'] = "Update failed: Record not found or not allowed.";
        }
    } else {
        $_SESSION['message'] = "Update failed: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: viewresults.php");
exit();
