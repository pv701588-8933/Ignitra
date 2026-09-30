<?php
session_start();
if (!isset($_SESSION["user_id"])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Feedback & Complaints | Ignitra</title><link rel="stylesheet" href="Assets/css/style.css"></head>
<body>
<header class="navbar"><div class="brand"><img src="Assets/css/images/Ignitra logo.JPEG" alt="Ignitra Logo"><div class="brand-text"><strong>IGNITRA</strong><span>YOUTH COUNCIL</span></div></div><nav><a href="index.php">Home</a><a href="dashboard.php">Dashboard</a><a href="logout.php">Logout</a></nav></header>
<section class="section"><div style="max-width:900px;margin:40px auto;"><span class="section-label">STUDENT SUPPORT</span><h1>Feedback & Complaints</h1><p>Share your feedback or register a complaint with Ignitra.</p><div class="cards" style="margin-top:30px;"><article class="card"><div class="icon green">💬</div><h3>Submit Feedback</h3><p>Share your suggestions or experience with us.</p><a href="feedback_submit.php">Give Feedback →</a></article><article class="card"><div class="icon orange">📩</div><h3>Register a Complaint</h3><p>Report an issue and track its status.</p><a href="complaint_submit.php">Register Complaint →</a></article></div></div></section></body></html>