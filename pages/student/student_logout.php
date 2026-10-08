<?php
session_start();

// Remove all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to student login page
header("Location: student_login.php");
exit();
?>