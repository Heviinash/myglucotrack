<?php
// session_terminated.php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Terminated</title>
    <meta http-equiv="refresh" content="3;url=../auth/login.php"> <!-- redirects after 3 sec -->
    <script>
        setTimeout(() => {
            window.location.href = "../auth/login.php"; // fallback for JS enabled
        }, 3000);
    </script>
</head>
<body>
    <div style="text-align:center; margin-top:50px;">
        <h2>Your session has expired due to inactivity.</h2>
        <p>Redirecting to login page...</p>
    </div>
</body>
</html>
