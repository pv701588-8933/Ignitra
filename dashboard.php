<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$name = $_SESSION["name"];
$role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Ignitra</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<header class="navbar">

    <div class="brand">

        <img src="images/ignitra-logo.jpg" alt="Ignitra Logo">

        <div class="brand-text">

            <strong>IGNITRA</strong>

            <span>YOUTH COUNCIL</span>

        </div>

    </div>

    <nav>

        <a href="index.php">Home</a>

        <a href="dashboard.php">Dashboard</a>

        <a href="logout.php">Logout</a>

    </nav>

</header>


<section class="section">

    <div style="max-width: 1100px; margin: 40px auto;">

        <span class="section-label">MY IGNITRA</span>

        <h1>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h1>

        <p>
            Your Ignitra journey starts here.
        </p>


        <div class="cards" style="margin-top:40px;">

            <article class="card">

                <div class="icon orange">📚</div>

                <h3>Guidance Resources</h3>

                <p>
                    Explore roadmaps, courses and career guidance.
                </p>

                <a href="index.php#guidance">
                    Explore Guidance →
                </a>

            </article>


            <article class="card">

                <div class="icon green">❓</div>

                <h3>Ask a Question</h3>

                <p>
                    Ask a question and get guidance from an approved volunteer.
                </p>

                <a href="#">
                    Ask Question →
                </a>

            </article>


            <article class="card">

                <div class="icon orange">👥</div>

                <h3>Communities</h3>

                <p>
                    Join communities and learn with other students.
                </p>

                <a href="index.php#communities">
                    Explore Communities →
                </a>

            </article>


            <article class="card">

                <div class="icon green">💬</div>

                <h3>Feedback & Complaints</h3>

                <p>
                    Share feedback or register and track a complaint.
                </p>

                <a href="#">
                    Feedback & Complaints →
                </a>

            </article>

        </div>


        <?php if ($role === "volunteer"): ?>

            <div style="margin-top:50px;">

                <span class="section-label">VOLUNTEER</span>

                <h2>Volunteer Area</h2>

                <p>
                    Manage your guidance profile and help students.
                </p>

            </div>

        <?php endif; ?>


        <?php if ($role === "admin"): ?>

            <div style="margin-top:50px;">

                <span class="section-label">ADMINISTRATION</span>

                <h2>Admin Area</h2>

                <p>
                    Manage users, resources, questions, volunteers and complaints.
                </p>

            </div>

        <?php endif; ?>

    </div>

</section>


</body>

</html>