<?php
session_start();
require_once "config/database.php";
if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
$message=""; $success="";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $feedback=trim($_POST["message"] ?? "");
    if ($feedback === "") { $message="Please enter your feedback."; }
    else {
        $stmt=$conn->prepare("INSERT INTO feedback (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION["user_id"], $feedback);
        if ($stmt->execute()) $success="Thank you! Your feedback has been submitted successfully.";
        else $message="Something went wrong. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Submit Feedback | Ignitra</title><link rel="stylesheet" href="Assets/css/style.css"></head>
<body>
<header class="navbar"><div class="brand"><img src="Assets/css/images/Ignitra logo.JPEG" alt="Ignitra Logo"><div class="brand-text"><strong>IGNITRA</strong><span>YOUTH COUNCIL</span></div></div><nav><a href="index.php">Home</a><a href="dashboard.php">Dashboard</a><a href="logout.php">Logout</a></nav></header>
<section class="section"><div style="max-width:700px;margin:40px auto;"><span class="section-label">STUDENT SUPPORT</span><h1>Submit Feedback</h1><?php if($message): ?><p style="color:#b95105;"><?php echo htmlspecialchars($message); ?></p><?php endif; ?><?php if($success): ?><div class="card"><p style="color:#466b32;"><?php echo htmlspecialchars($success); ?></p><a href="dashboard.php">Back to Dashboard →</a></div><?php else: ?><form method="POST" class="card"><label>Your Feedback</label><textarea name="message" rows="7" required placeholder="Write your feedback here..." style="width:100%;padding:12px;margin:8px 0 18px;"></textarea><button type="submit" class="login-btn" style="border:none;cursor:pointer;padding:12px 24px;">Submit Feedback</button></form><?php endif; ?></div></section></body></html>