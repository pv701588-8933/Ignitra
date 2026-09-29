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
    header("Location: complaints.php");
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
    header("Location: complaints.php");
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

        <a href="complaints.php">Complaints</a>

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
                        value="Submitted"
                        <?php
                        if ($complaint["status"] === "Submitted") {
                            echo "selected";
                        }
                        ?>
                    >
                        Submitted
                    </option>


                    <option
                        value="Under Review"
                        <?php
                        if ($complaint["status"] === "Under Review") {
                            echo "selected";
                        }
                        ?>
                    >
                        Under Review
                    </option>


                    <option
                        value="In Progress"
                        <?php
                        if ($complaint["status"] === "In Progress") {
                            echo "selected";
                        }
                        ?>
                    >
                        In Progress
                    </option>


                    <option
                        value="Resolved"
                        <?php
                        if ($complaint["status"] === "Resolved") {
                            echo "selected";
                        }
                        ?>
                    >
                        Resolved
                    </option>


                    <option
                        value="Rejected"
                        <?php
                        if ($complaint["status"] === "Rejected") {
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

            <a href="complaints.php">
                ← Back to Complaints
            </a>

        </p>


    </section>


</main>


</body>

</html>