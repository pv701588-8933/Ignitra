<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Ignitra</title>

    <link rel="stylesheet" href="../Assets/css/style.css">
</head>

<body>

<header class="navbar">

    <div class="logo">
        <img
    src="../Assets/css/images/Ignitra logo.JPEG"
    alt="Ignitra Logo"
    style="width: 120px; height: auto; object-fit: contain;"
>
    </div>

    <nav>
        <a href="../index.php">Home</a>
        <a href="dashboard.php">Admin Dashboard</a>
        <a href="../logout.php">Logout</a>
    </nav>

</header>


<main class="container">

    <section class="hero">

        <h1>Welcome, Admin</h1>

        <p>
            Manage users, complaints, feedback and other Ignitra activities
            from one place.
        </p>

    </section>


    <section class="cards">

        <div class="card">
            <h2>Users</h2>
            <p>View and manage students and volunteers.</p>
        </div>


        <div class="card">
            <h2>Complaints</h2>
            <p>Review complaints and manage their status.</p>

            <a href="complaints.php" class="btn">
                Manage Complaints
            </a>
        </div>


        <div class="card">
            <h2>Feedback</h2>
            <p>Review feedback submitted by students.</p>

            <a href="feedback.php" class="btn">
                Manage Feedback
            </a>
        </div>


        <div class="card">
            <h2>Volunteer Applications</h2>
            <p>
                Volunteer application management will be available
                in the volunteer module.
            </p>
        </div>

    </section>

</main>

</body>
</html>