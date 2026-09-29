<?php

session_start();

require_once "../config/database.php";


// Admin access protection
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}


// Fetch all feedback
$sql = "SELECT
            feedback.id,
            feedback.message,
            feedback.created_at,
            users.name,
            users.email
        FROM feedback
        INNER JOIN users
        ON feedback.user_id = users.id
        ORDER BY feedback.created_at DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Feedback | Ignitra</title>

    <link rel="stylesheet" href="../Assets/css/style.css">

</head>


<body>


<header class="navbar">

    <div class="logo">

        <img
            src="../Assets/css/images/Ignitra logo.JPEG"
            alt="Ignitra Logo"
            style="width:120px; height:auto; object-fit:contain;"
        >

    </div>


    <nav>

        <a href="../index.php">Home</a>

        <a href="dashboard.php">Admin Dashboard</a>

        <a href="complaints.php">Complaints</a>

        <a href="feedback.php">Feedback</a>

        <a href="../logout.php">Logout</a>

    </nav>

</header>



<main class="container">


    <section class="hero">

        <h1>Feedback Management</h1>

        <p>
            Review feedback submitted by students.
        </p>

    </section>



    <section class="section">


        <?php if ($result && $result->num_rows > 0): ?>


            <div style="overflow-x:auto;">

                <table
                    style="
                        width:100%;
                        border-collapse:collapse;
                        background:white;
                    "
                >

                    <thead>

                        <tr>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Student
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Email
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Feedback
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Date
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php while ($feedback = $result->fetch_assoc()): ?>

                            <tr>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $feedback["name"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $feedback["email"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo nl2br(
                                        htmlspecialchars(
                                            $feedback["message"]
                                        )
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $feedback["created_at"]
                                    );
                                    ?>

                                </td>


                            </tr>

                        <?php endwhile; ?>


                    </tbody>

                </table>

            </div>


        <?php else: ?>


            <div class="card">

                <h2>No Feedback Found</h2>

                <p>
                    There is currently no feedback submitted by students.
                </p>

            </div>


        <?php endif; ?>


    </section>


</main>


</body>

</html>