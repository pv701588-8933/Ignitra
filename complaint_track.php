<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$complaint = null;
$message = "";

if (isset($_GET["id"])) {

    $complaint_id = trim($_GET["id"]);
    $user_id = $_SESSION["user_id"];

    $stmt = $conn->prepare(
        "SELECT complaint_id, category, related_module,
                description, status, admin_response,
                created_at, updated_at
         FROM complaints
         WHERE complaint_id = ? AND user_id = ?"
    );

    $stmt->bind_param("si", $complaint_id, $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $complaint = $result->fetch_assoc();
    } else {
        $message = "Complaint not found.";
    }

} else {
    $message = "No complaint ID provided.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Track Complaint | Ignitra</title>

    <link rel="stylesheet" href="Assets/css/style.css">

</head>

<body>

<header class="navbar">

    <div class="brand">

        <img src="Assets/css/images/Ignitra logo.JPEG" alt="Ignitra Logo">

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

    <div style="max-width: 750px; margin: 40px auto;">

        <span class="section-label">SUPPORT</span>

        <h1>Complaint Tracking</h1>


        <?php if ($complaint): ?>

            <div class="card" style="margin-top:30px;">

                <h2>
                    Complaint ID:
                    <?php echo htmlspecialchars($complaint["complaint_id"]); ?>
                </h2>


                <p>
                    <strong>Status:</strong>

                    <?php echo htmlspecialchars($complaint["status"]); ?>
                </p>


                <p>
                    <strong>Category:</strong>

                    <?php echo htmlspecialchars($complaint["category"]); ?>
                </p>


                <p>
                    <strong>Related Module:</strong>

                    <?php echo htmlspecialchars($complaint["related_module"]); ?>
                </p>


                <p>
                    <strong>Description:</strong><br>

                    <?php echo nl2br(
                        htmlspecialchars($complaint["description"])
                    ); ?>
                </p>


                <hr>


                <h3>Admin Response</h3>

                <?php if (!empty($complaint["admin_response"])): ?>

                    <p>
                        <?php echo nl2br(
                            htmlspecialchars($complaint["admin_response"])
                        ); ?>
                    </p>

                <?php else: ?>

                    <p>
                        Your complaint is currently being reviewed.
                    </p>

                <?php endif; ?>


                <p style="margin-top:25px;">

                    <strong>Submitted:</strong>

                    <?php echo htmlspecialchars(
                        $complaint["created_at"]
                    ); ?>

                </p>


                <p>

                    <strong>Last Updated:</strong>

                    <?php echo htmlspecialchars(
                        $complaint["updated_at"]
                    ); ?>

                </p>

            </div>


            <div style="margin-top:25px;">

                <a href="complaint_submit.php">
                    Register Another Complaint →
                </a>

            </div>


        <?php else: ?>

            <div class="card" style="margin-top:30px;">

                <p>
                    <?php echo htmlspecialchars($message); ?>
                </p>

                <a href="dashboard.php">
                    Return to Dashboard →
                </a>

            </div>

        <?php endif; ?>

    </div>

</section>

</body>

</html>