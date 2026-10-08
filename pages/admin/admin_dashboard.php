<?php
session_start();

require_once "../../config/database.php";

// Admin must be logged in
if (!isset($_SESSION["admin_id"]) || $_SESSION["admin_role"] !== "admin") {
    header("Location: admin_login.php");
    exit();
}

// Get total students
$student_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'student'
");

$total_students = $student_query->fetch_assoc()["total"];

// Get total volunteers
$volunteer_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM users
    WHERE role = 'volunteer'
");

$total_volunteers = $volunteer_query->fetch_assoc()["total"];

// Get total complaints
$complaint_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM complaints
");

$total_complaints = $complaint_query->fetch_assoc()["total"];

// Get submitted complaints
$submitted_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM complaints
    WHERE status = 'submitted'
");

$submitted_complaints = $submitted_query->fetch_assoc()["total"];

// Get resolved complaints
$resolved_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM complaints
    WHERE status = 'resolved'
");

$resolved_complaints = $resolved_query->fetch_assoc()["total"];

// Get total feedback
$feedback_query = $conn->query("
    SELECT COUNT(*) AS total
    FROM feedback
");

$total_feedback = $feedback_query->fetch_assoc()["total"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard | IGNITRA</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7efe3;
            color: #333;
            min-height: 100vh;
        }

        /* NAVBAR */

        .navbar {
            background: #ffffff;
            padding: 14px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
        }

        .logo img {
            width: 125px;
            display: block;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-name {
            color: #555;
            font-size: 14px;
        }

        .logout {
            text-decoration: none;
            background: #d87532;
            color: #ffffff;
            padding: 9px 15px;
            border-radius: 6px;
            font-size: 13px;
        }

        .logout:hover {
            background: #c66325;
        }

        /* MAIN */

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 35px 25px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            color: #c65f21;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
            font-size: 14px;
        }

        /* STAT CARDS */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: #ffffff;
            padding: 23px;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .stat-title {
            color: #777;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
            color: #c65f21;
        }

        /* SECTION */

        .section-title {
            color: #c65f21;
            margin-bottom: 18px;
            font-size: 21px;
        }

        /* MANAGEMENT CARDS */

        .management {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .management-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .management-card h3 {
            color: #444;
            margin-bottom: 9px;
        }

        .management-card p {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .management-card a {
            display: inline-block;
            text-decoration: none;
            background: #d87532;
            color: #ffffff;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 13px;
        }

        .management-card a:hover {
            background: #c66325;
        }

        /* COMPLAINT SUMMARY */

        .summary {
            margin-top: 35px;
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 13px 0;
            border-bottom: 1px solid #eee3d7;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #555;
        }

        .summary-value {
            font-weight: bold;
            color: #c65f21;
        }

        @media (max-width: 900px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .management {
                grid-template-columns: 1fr 1fr;
            }

        }

        @media (max-width: 600px) {

            .navbar {
                padding: 14px 18px;
            }

            .admin-name {
                display: none;
            }

            .stats,
            .management {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar">

    <div class="logo">
        <img src="../../assets/images/ingitra.png" alt="IGNITRA">
    </div>

    <div class="admin-info">

        <span class="admin-name">
            Welcome, <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>
        </span>

        <a href="admin_logout.php" class="logout">
            Logout
        </a>

    </div>

</nav>


<!-- MAIN -->

<div class="container">

    <div class="welcome">

        <h1>Admin Dashboard</h1>

        <p>
            Manage users, complaints, feedback and IGNITRA resources.
        </p>

    </div>


    <!-- STATISTICS -->

    <div class="stats">

        <div class="stat-card">

            <div class="stat-title">
                Total Students
            </div>

            <div class="stat-number">
                <?php echo $total_students; ?>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Total Volunteers
            </div>

            <div class="stat-number">
                <?php echo $total_volunteers; ?>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Total Complaints
            </div>

            <div class="stat-number">
                <?php echo $total_complaints; ?>
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                Total Feedback
            </div>

            <div class="stat-number">
                <?php echo $total_feedback; ?>
            </div>

        </div>

    </div>


    <!-- MANAGEMENT -->

    <h2 class="section-title">
        Management
    </h2>

    <div class="management">

        <div class="management-card">

            <h3>Complaint Management</h3>

            <p>
                Review student and volunteer complaints, update their
                status and provide administrative responses.
            </p>

            <a href="complaint.php">
                Manage Complaints
            </a>

        </div>


        <div class="management-card">

            <h3>Feedback Management</h3>

            <p>
                Review feedback submitted by users and monitor their
                experience with IGNITRA.
            </p>

            <a href="feedback.php">
                View Feedback
            </a>

        </div>


        <div class="management-card">

            <h3>Volunteer Management</h3>

            <p>
                Review volunteer applications and manage verified
                volunteers.
            </p>

            <a href="manage_volunteer.php">
                Manage Volunteers
            </a>

        </div>


        <div class="management-card">

            <h3>User Management</h3>

            <p>
                View and manage registered students, volunteers and
                administrators.
            </p>

            <a href="users.php">
                Manage Users
            </a>

        </div>


        <div class="management-card">

            <h3>Roadmap Management</h3>

            <p>
                Upload and manage official guidance roadmaps available
                to students.
            </p>

            <a href="roadmap.php">
                Manage Roadmaps
            </a>

        </div>


        <div class="management-card">

            <h3>Community Management</h3>

            <p>
                Monitor and manage communities and relevant platform
                content.
            </p>

            <a href="community.php">
                Manage Communities
            </a>

        </div>

    </div>


    <!-- COMPLAINT SUMMARY -->

    <div class="summary">

        <h2 class="section-title">
            Complaint Overview
        </h2>

        <div class="summary-row">

            <span class="summary-label">
                Total Complaints
            </span>

            <span class="summary-value">
                <?php echo $total_complaints; ?>
            </span>

        </div>


        <div class="summary-row">

            <span class="summary-label">
                Submitted / Pending Review
            </span>

            <span class="summary-value">
                <?php echo $submitted_complaints; ?>
            </span>

        </div>


        <div class="summary-row">

            <span class="summary-label">
                Resolved Complaints
            </span>

            <span class="summary-value">
                <?php echo $resolved_complaints; ?>
            </span>

        </div>

    </div>

</div>

</body>

</html>