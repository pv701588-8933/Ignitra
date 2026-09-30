<?php

session_start();

require_once "../config/database.php";


// Admin access protection
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}


// Check complaint ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: complaint.php");
    exit;
}

$id = (int) $_GET["id"];


// Update complaint
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $status = trim($_POST["status"]);
    $admin_response = trim($_POST["admin_response"]);

    $stmt = $conn->prepare(
        "UPDATE complaints
         SET status = ?, admin_response = ?, updated_at = NOW()
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssi",
        $status,
        $admin_response,
        $id
    );

    $stmt->execute();

    header("Location: complaint_view.php?id=" . $id . "&updated=1");
    exit;
}


// Get complaint details
$stmt = $conn->prepare(
    "SELECT
        complaints.*,
        users.name,
        users.email
     FROM complaints
     INNER JOIN users
     ON complaints.user_id = users.id
     WHERE complaints.id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();


// Complaint not found
if ($result->num_rows !== 1) {
    header("Location: complaint.php");
    exit;
}

$complaint = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Complaint | Ignitra</title>

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

        <a href="complaint.php">Complaints</a>

        <a href="../logout.php">Logout</a>

    </nav>

</header>



<main class="container">


    <section class="hero">

        <h1>Complaint Details</h1>

        <p>
            Review and manage this student complaint.
        </p>

    </section>



    <?php if (isset($_GET["updated"])): ?>

        <div class="card">

            <p style="color:#466b32;">

                Complaint updated successfully.

            </p>

        </div>

    <?php endif; ?>



    <section class="section">


        <div class="card">

            <h2>
                <?php
                echo htmlspecialchars($complaint["complaint_id"]);
                ?>
            </h2>


            <p>
                <strong>Student:</strong>

                <?php
                echo htmlspecialchars($complaint["name"]);
                ?>
            </p>


            <p>
                <strong>Email:</strong>

                <?php
                echo htmlspecialchars($complaint["email"]);
                ?>
            </p>


            <p>
                <strong>Category:</strong>

                <?php
                echo htmlspecialchars($complaint["category"]);
                ?>
            </p>


            <p>
                <strong>Related Module:</strong>

                <?php
                echo htmlspecialchars($complaint["related_module"]);
                ?>
            </p>


            <p>
                <strong>Submitted:</strong>

                <?php
                echo htmlspecialchars($complaint["created_at"]);
                ?>
            </p>


            <hr>


            <h3>Complaint Description</h3>

            <p>
                <?php
                echo nl2br(
                    htmlspecialchars($complaint["description"])
                );
                ?>
            </p>

        </div>



        <div class="card">

            <h2>Admin Action</h2>


            <form method="POST">


                <label for="status">
                    Complaint Status
                </label>


                <select
                    name="status"
                    id="status"
                    required
                    style="width:100%; padding:12px; margin:8px 0 20px;"
                >

                    <option
                        value="submitted"
                        <?php
                        if ($complaint["status"] === "submitted") {
                            echo "selected";
                        }
                        ?>
                    >
                        Submitted
                    </option>


                    <option
                        value="under_review"
                        <?php
                        if ($complaint["status"] === "under_review") {
                            echo "selected";
                        }
                        ?>
                    >
                        Under Review
                    </option>


                    <option
                        value="in_progress"
                        <?php
                        if ($complaint["status"] === "in_progress") {
                            echo "selected";
                        }
                        ?>
                    >
                        In Progress
                    </option>


                    <option
                        value="resolved"
                        <?php
                        if ($complaint["status"] === "resolved") {
                            echo "selected";
                        }
                        ?>
                    >
                        Resolved
                    </option>


                    <option
                        value="rejected"
                        <?php
                        if ($complaint["status"] === "rejected") {
                            echo "selected";
                        }
                        ?>
                    >
                        Rejected
                    </option>

                </select>



                <label for="admin_response">
                    Admin Response
                </label>


                <textarea
                    name="admin_response"
                    id="admin_response"
                    rows="6"
                    placeholder="Write your response to the student..."
                    style="width:100%; padding:12px; margin:8px 0 20px;"
                ><?php
                    echo htmlspecialchars(
                        $complaint["admin_response"] ?? ""
                    );
                ?></textarea>



                <button
                    type="submit"
                    class="btn"
                    style="border:none; cursor:pointer;"
                >
                    Update Complaint
                </button>


            </form>

        </div>



        <p style="margin-top:20px;">

            <a href="complaint.php">
                ← Back to Complaints
            </a>

        </p>


    </section>


</main>


</body>

</html>