<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard - IGNITRA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #222;
        }

        .navbar {
            background: #1f2937;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .logout {
            color: white;
            text-decoration: none;
            background: #dc2626;
            padding: 9px 16px;
            border-radius: 6px;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            margin-bottom: 8px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>IGNITRA | Volunteer</h2>
    <a href="../logout.php" class="logout">Logout</a>
</div>

<div class="container">

    <div class="welcome">
        <h1>Volunteer Dashboard</h1>
        <p>Welcome to the IGNITRA volunteer portal.</p>
    </div>

    <div class="cards">

        <div class="card">
            <h3>My Profile</h3>
            <p>View and update your volunteer information, skills and expertise.</p>
            <a href="profile.php" class="btn">View Profile</a>
        </div>

        <div class="card">
            <h3>Opportunities</h3>
            <p>Explore available community volunteering opportunities.</p>
            <a href="opportunities.php" class="btn">View Opportunities</a>
        </div>

        <div class="card">
            <h3>My Activities</h3>
            <p>Track your volunteer participation and activities.</p>
            <a href="activities.php" class="btn">My Activities</a>
        </div>

    </div>

</div>

</body>
</html>