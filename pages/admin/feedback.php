<?php
session_start();

require_once "../../config/database.php";

/* =========================
   ADMIN ACCESS CHECK
========================= */

if (!isset($_SESSION["admin_id"]) || $_SESSION["admin_role"] !== "admin") {
    header("Location: admin_login.php");
    exit();
}


/* =========================
   FETCH FEEDBACK
========================= */

$feedback_result = $conn->query("
    SELECT 
        f.id,
        f.user_id,
        f.message,
        f.created_at,
        u.name,
        u.email,
        u.role
    FROM feedback f
    LEFT JOIN users u
        ON f.user_id = u.id
    ORDER BY f.created_at DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Feedback Management - IGNITRA</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f7efe3;
            color: #333;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            background: #ffffff;
            padding: 15px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .logo {
            height: 45px;
            width: auto;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-right a {
            text-decoration: none;
            color: #7a3e00;
            font-weight: 600;
        }

        .logout {
            background: #e97817;
            color: white !important;
            padding: 9px 16px;
            border-radius: 6px;
        }

        /* =========================
           CONTAINER
        ========================= */

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 35px auto;
        }

        h1 {
            color: #8b4500;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }

        /* =========================
           FEEDBACK CARD
        ========================= */

        .feedback-card {
            background: #ffffff;
            padding: 24px;
            margin-bottom: 20px;

            border-radius: 10px;

            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            padding-bottom: 15px;
            margin-bottom: 18px;

            border-bottom: 1px solid #eee;
        }

        .user-info h3 {
            color: #7a3e00;
            margin-bottom: 5px;
        }

        .user-info p {
            color: #777;
            font-size: 14px;
        }

        .feedback-id {
            background: #fff0dd;
            color: #a65300;

            padding: 7px 12px;
            border-radius: 20px;

            font-size: 13px;
            font-weight: bold;
        }

        /* =========================
           DETAILS
        ========================= */

        .details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;

            margin-bottom: 18px;
        }

        .detail-box {
            background: #faf5ed;
            padding: 13px;
            border-radius: 7px;
        }

        .detail-box strong {
            display: block;
            color: #7a3e00;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .detail-box span {
            color: #444;
        }

        /* =========================
           MESSAGE
        ========================= */

        .message-box {
            background: #fffaf4;

            padding: 18px;

            border-left: 4px solid #e97817;

            border-radius: 6px;

            line-height: 1.6;
        }

        .message-box strong {
            display: block;
            color: #7a3e00;
            margin-bottom: 8px;
        }

        /* =========================
           EMPTY
        ========================= */

        .empty {
            background: white;
            padding: 40px;

            text-align: center;

            border-radius: 10px;

            color: #777;
        }

        .empty h3 {
            color: #7a3e00;
            margin-bottom: 8px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 700px) {

            .navbar {
                padding: 15px 20px;
            }

            .container {
                width: 94%;
            }

            .feedback-header {
                flex-direction: column;
                gap: 12px;
            }

            .details {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<div class="navbar">

    <a href="admin_dashboard.php">

        <img
            src="../../assets/images/ingitra.png"
            alt="IGNITRA"
            class="logo"
        >

    </a>


    <div class="nav-right">

        <a href="admin_dashboard.php">
            Dashboard
        </a>

        <a href="admin_logout.php" class="logout">
            Logout
        </a>

    </div>

</div>


<!-- =========================
     MAIN CONTENT
========================= -->

<div class="container">

    <h1>
        Feedback Management
    </h1>

    <p class="subtitle">
        View feedback submitted by students and volunteers.
    </p>


    <?php if ($feedback_result && $feedback_result->num_rows > 0): ?>


        <?php while ($feedback = $feedback_result->fetch_assoc()): ?>


            <div class="feedback-card">


                <!-- HEADER -->

                <div class="feedback-header">

                    <div class="user-info">

                        <h3>
                            <?php
                            echo htmlspecialchars(
                                $feedback["name"] ?? "Unknown User"
                            );
                            ?>
                        </h3>

                        <p>
                            <?php
                            echo htmlspecialchars(
                                $feedback["email"] ?? "No email"
                            );
                            ?>
                        </p>

                    </div>


                    <div class="feedback-id">

                        Feedback #<?php
                        echo htmlspecialchars($feedback["id"]);
                        ?>

                    </div>

                </div>


                <!-- DETAILS -->

                <div class="details">


                    <div class="detail-box">

                        <strong>
                            User ID
                        </strong>

                        <span>
                            <?php
                            echo htmlspecialchars(
                                $feedback["user_id"]
                            );
                            ?>
                        </span>

                    </div>


                    <div class="detail-box">

                        <strong>
                            User Role
                        </strong>

                        <span>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $feedback["role"] ?? "User"
                                )
                            );
                            ?>
                        </span>

                    </div>


                    <div class="detail-box">

                        <strong>
                            Submitted On
                        </strong>

                        <span>
                            <?php
                            echo htmlspecialchars(
                                $feedback["created_at"]
                            );
                            ?>
                        </span>

                    </div>


                </div>


                <!-- MESSAGE -->

                <div class="message-box">

                    <strong>
                        Feedback Message
                    </strong>

                    <?php

                    echo nl2br(
                        htmlspecialchars(
                            $feedback["message"]
                        )
                    );

                    ?>

                </div>


            </div>


        <?php endwhile; ?>


    <?php else: ?>


        <div class="empty">

            <h3>
                No Feedback Found
            </h3>

            <p>
                No feedback has been submitted yet.
            </p>

        </div>


    <?php endif; ?>


</div>


</body>

</html>