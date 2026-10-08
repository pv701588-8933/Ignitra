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

$message = "";
$error = "";


/* =========================
   UPDATE VOLUNTEER STATUS
========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_status"])) {

    $profile_id = intval($_POST["profile_id"]);
    $status = trim($_POST["status"]);

    /* Allow only valid statuses */
    $allowed_statuses = ["pending", "approved", "rejected"];

    if (!in_array($status, $allowed_statuses)) {

        $error = "Invalid volunteer status.";

    } else {

        $stmt = $conn->prepare("
            UPDATE volunteer_profiles
            SET status = ?
            WHERE id = ?
        ");

        if ($stmt) {

            $stmt->bind_param(
                "si",
                $status,
                $profile_id
            );

            if ($stmt->execute()) {

                $message = "Volunteer status updated successfully.";

            } else {

                $error = "Unable to update volunteer status.";
            }

            $stmt->close();

        } else {

            $error = "Database error: " . $conn->error;
        }
    }
}


/* =========================
   FETCH VOLUNTEER APPLICATIONS
========================= */

$volunteer_result = $conn->query("
    SELECT
        vp.id,
        vp.user_id,
        vp.education,
        vp.profession,
        vp.skills,
        vp.expertise,
        vp.bio,
        vp.status,
        u.name,
        u.email
    FROM volunteer_profiles vp
    LEFT JOIN users u
        ON vp.user_id = u.id
    ORDER BY vp.id DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Volunteers - IGNITRA</title>


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
           MAIN CONTAINER
        ========================= */

        .container {
            width: 92%;
            max-width: 1150px;
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
           MESSAGES
        ========================= */

        .success {
            background: #fff4df;

            border-left: 5px solid #e97817;

            padding: 14px;

            margin-bottom: 20px;

            border-radius: 5px;
        }

        .error {
            background: #ffe5dc;

            border-left: 5px solid #c94b18;

            padding: 14px;

            margin-bottom: 20px;

            border-radius: 5px;
        }


        /* =========================
           VOLUNTEER CARD
        ========================= */

        .volunteer-card {
            background: #ffffff;

            border-radius: 10px;

            padding: 25px;

            margin-bottom: 22px;

            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }


        /* =========================
           CARD HEADER
        ========================= */

        .card-header {
            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 20px;

            padding-bottom: 18px;

            margin-bottom: 20px;

            border-bottom: 1px solid #eee;
        }

        .applicant h2 {
            color: #7a3e00;

            margin-bottom: 6px;
        }

        .applicant p {
            color: #777;

            font-size: 14px;

            margin-bottom: 3px;
        }


        /* =========================
           STATUS BADGE
        ========================= */

        .status {
            padding: 8px 15px;

            border-radius: 20px;

            font-size: 13px;

            font-weight: bold;

            text-transform: capitalize;

            white-space: nowrap;
        }

        .status.pending {
            background: #fff0dd;
            color: #a65300;
        }

        .status.approved {
            background: #f4eadc;
            color: #7a3e00;
        }

        .status.rejected {
            background: #f3dfd2;
            color: #8b3e00;
        }


        /* =========================
           APPLICATION DETAILS
        ========================= */

        .details {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 15px;

            margin-bottom: 20px;
        }

        .detail-box {
            background: #faf5ed;

            padding: 15px;

            border-radius: 7px;
        }

        .detail-box strong {
            display: block;

            color: #7a3e00;

            font-size: 13px;

            margin-bottom: 7px;
        }

        .detail-box span {
            color: #444;

            line-height: 1.5;
        }


        /* =========================
           BIO
        ========================= */

        .bio-box {
            background: #fffaf4;

            padding: 16px;

            border-left: 4px solid #e97817;

            border-radius: 6px;

            margin-bottom: 20px;

            line-height: 1.6;
        }

        .bio-box strong {
            display: block;

            color: #7a3e00;

            margin-bottom: 7px;
        }


        /* =========================
           STATUS UPDATE
        ========================= */

        .update-section {
            border-top: 1px solid #eee;

            padding-top: 20px;
        }

        .update-section h3 {
            color: #7a3e00;

            font-size: 17px;

            margin-bottom: 12px;
        }

        .update-form {
            display: flex;

            align-items: center;

            gap: 12px;

            flex-wrap: wrap;
        }

        select {
            padding: 10px 12px;

            border: 1px solid #ddd;

            border-radius: 6px;

            background: #ffffff;

            font-size: 14px;
        }

        select:focus {
            outline: none;

            border-color: #e97817;
        }

        .update-btn {
            background: #e97817;

            color: white;

            border: none;

            padding: 10px 18px;

            border-radius: 6px;

            cursor: pointer;

            font-weight: 600;
        }

        .update-btn:hover {
            background: #c95f0c;
        }


        /* =========================
           EMPTY STATE
        ========================= */

        .empty {
            background: #ffffff;

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

            .card-header {
                flex-direction: column;
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

        <a
            href="admin_logout.php"
            class="logout"
        >
            Logout
        </a>

    </div>

</div>



<!-- =========================
     MAIN CONTENT
========================= -->

<div class="container">

    <h1>
        Volunteer Management
    </h1>

    <p class="subtitle">
        Review volunteer applications and verify their eligibility before granting access.
    </p>


    <?php if ($message): ?>

        <div class="success">
            <?php
            echo htmlspecialchars($message);
            ?>
        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div class="error">
            <?php
            echo htmlspecialchars($error);
            ?>
        </div>

    <?php endif; ?>


    <?php if ($volunteer_result && $volunteer_result->num_rows > 0): ?>


        <?php while ($volunteer = $volunteer_result->fetch_assoc()): ?>


            <div class="volunteer-card">


                <!-- =========================
                     APPLICANT HEADER
                ========================= -->

                <div class="card-header">

                    <div class="applicant">

                        <h2>
                            <?php
                            echo htmlspecialchars(
                                $volunteer["name"] ?? "Unknown Applicant"
                            );
                            ?>
                        </h2>

                        <p>
                            Email:
                            <?php
                            echo htmlspecialchars(
                                $volunteer["email"] ?? "Not available"
                            );
                            ?>
                        </p>

                        <p>
                            User ID:
                            <?php
                            echo htmlspecialchars(
                                $volunteer["user_id"]
                            );
                            ?>
                        </p>

                    </div>


                    <div class="status <?php
                        echo htmlspecialchars(
                            strtolower(
                                $volunteer["status"] ?? "pending"
                            )
                        );
                    ?>">

                        <?php
                        echo htmlspecialchars(
                            $volunteer["status"] ?? "pending"
                        );
                        ?>

                    </div>

                </div>


                <!-- =========================
                     APPLICATION DETAILS
                ========================= -->

                <div class="details">


                    <div class="detail-box">

                        <strong>
                            Education
                        </strong>

                        <span>
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $volunteer["education"] ?? "Not provided"
                                )
                            );
                            ?>
                        </span>

                    </div>


                    <div class="detail-box">

                        <strong>
                            Profession
                        </strong>

                        <span>
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $volunteer["profession"] ?? "Not provided"
                                )
                            );
                            ?>
                        </span>

                    </div>


                    <div class="detail-box">

                        <strong>
                            Skills
                        </strong>

                        <span>
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $volunteer["skills"] ?? "Not provided"
                                )
                            );
                            ?>
                        </span>

                    </div>


                    <div class="detail-box">

                        <strong>
                            Expertise
                        </strong>

                        <span>
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $volunteer["expertise"] ?? "Not provided"
                                )
                            );
                            ?>
                        </span>

                    </div>


                </div>


                <!-- =========================
                     BIO
                ========================= -->

                <div class="bio-box">

                    <strong>
                        Volunteer Introduction / Bio
                    </strong>

                    <?php

                    if (!empty($volunteer["bio"])) {

                        echo nl2br(
                            htmlspecialchars(
                                $volunteer["bio"]
                            )
                        );

                    } else {

                        echo "No introduction provided.";

                    }

                    ?>

                </div>


                <!-- =========================
                     UPDATE STATUS
                ========================= -->

                <div class="update-section">

                    <h3>
                        Application Decision
                    </h3>


                    <form
                        method="POST"
                        class="update-form"
                    >

                        <input
                            type="hidden"
                            name="profile_id"
                            value="<?php
                                echo htmlspecialchars(
                                    $volunteer["id"]
                                );
                            ?>"
                        >


                        <select name="status" required>

                            <option
                                value="pending"
                                <?php
                                echo (
                                    $volunteer["status"] === "pending"
                                ) ? "selected" : "";
                                ?>
                            >
                                Pending
                            </option>


                            <option
                                value="approved"
                                <?php
                                echo (
                                    $volunteer["status"] === "approved"
                                ) ? "selected" : "";
                                ?>
                            >
                                Approve
                            </option>


                            <option
                                value="rejected"
                                <?php
                                echo (
                                    $volunteer["status"] === "rejected"
                                ) ? "selected" : "";
                                ?>
                            >
                                Reject
                            </option>

                        </select>


                        <button
                            type="submit"
                            name="update_status"
                            class="update-btn"
                        >
                            Update Status
                        </button>

                    </form>

                </div>


            </div>


        <?php endwhile; ?>


    <?php else: ?>


        <div class="empty">

            <h3>
                No Volunteer Applications
            </h3>

            <p>
                There are currently no volunteer applications to review.
            </p>

        </div>


    <?php endif; ?>


</div>


</body>

</html>