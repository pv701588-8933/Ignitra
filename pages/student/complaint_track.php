<?php
session_start();

require_once "../../config/database.php";

// Check student login
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: student_login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Fetch only complaints submitted by the logged-in student
$stmt = $conn->prepare("
    SELECT
        complaint_id,
        category,
        related_module,
        description,
        status,
        admin_response,
        created_at,
        updated_at
    FROM complaints
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Track Complaints | IGNITRA</title>

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
            padding: 40px 20px;
        }

        .container {
            max-width: 1050px;
            margin: auto;
        }

        .header {
            background: #ffffff;
            padding: 25px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 12px;
        }

        .logo img {
            width: 140px;
        }

        h1 {
            text-align: center;
            color: #c65f21;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .complaints {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .complaint-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }

        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .complaint-id {
            font-size: 17px;
            font-weight: bold;
            color: #c65f21;
        }

        .status {
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            text-transform: capitalize;
            background: #f4e4d4;
            color: #9a551f;
        }

        .status.resolved {
            background: #e8f2df;
            color: #52743b;
        }

        .status.in_progress {
            background: #fff0d8;
            color: #9a5d22;
        }

        .status.closed {
            background: #ece7e0;
            color: #665f57;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .detail {
            background: #faf6f0;
            padding: 13px;
            border-radius: 7px;
        }

        .detail-label {
            display: block;
            font-size: 12px;
            color: #777;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .description {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .description-title {
            font-weight: bold;
            color: #444;
        }

        .admin-response {
            padding: 15px;
            background: #fff7ed;
            border-left: 4px solid #d87532;
            border-radius: 6px;
            line-height: 1.6;
        }

        .admin-response-title {
            color: #c65f21;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .no-complaints {
            background: #ffffff;
            padding: 50px 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        }

        .no-complaints h2 {
            color: #c65f21;
            margin-bottom: 10px;
        }

        .no-complaints p {
            color: #666;
        }

        .buttons {
            text-align: center;
            margin-top: 25px;
        }

        .buttons a {
            display: inline-block;
            text-decoration: none;
            background: #d87532;
            color: #ffffff;
            padding: 11px 18px;
            border-radius: 7px;
            margin: 5px;
            font-size: 14px;
        }

        .buttons a:hover {
            background: #c66325;
        }

        @media (max-width: 650px) {

            .complaint-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .details {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- Header -->
    <div class="header">

        <div class="logo">
            <img src="../../assets/images/ingitra.png" alt="IGNITRA">
        </div>

        <h1>Track My Complaints</h1>

        <p class="subtitle">
            View the status and response of your submitted complaints.
        </p>

    </div>


    <!-- Complaints -->
    <div class="complaints">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($complaint = $result->fetch_assoc()): ?>

                <?php
                $status = strtolower(trim($complaint["status"]));

                $status_class = str_replace(" ", "_", $status);
                ?>

                <div class="complaint-card">

                    <div class="complaint-header">

                        <div class="complaint-id">
                            <?php echo htmlspecialchars($complaint["complaint_id"]); ?>
                        </div>

                        <div class="status <?php echo htmlspecialchars($status_class); ?>">
                            <?php echo htmlspecialchars($complaint["status"]); ?>
                        </div>

                    </div>


                    <div class="details">

                        <div class="detail">

                            <span class="detail-label">
                                Category
                            </span>

                            <?php echo htmlspecialchars($complaint["category"]); ?>

                        </div>


                        <div class="detail">

                            <span class="detail-label">
                                Related Module
                            </span>

                            <?php echo htmlspecialchars($complaint["related_module"]); ?>

                        </div>


                        <div class="detail">

                            <span class="detail-label">
                                Submitted On
                            </span>

                            <?php echo htmlspecialchars($complaint["created_at"]); ?>

                        </div>


                        <div class="detail">

                            <span class="detail-label">
                                Last Updated
                            </span>

                            <?php echo htmlspecialchars($complaint["updated_at"]); ?>

                        </div>

                    </div>


                    <div class="description">

                        <div class="description-title">
                            Complaint Description
                        </div>

                        <p>
                            <?php
                            echo nl2br(
                                htmlspecialchars($complaint["description"])
                            );
                            ?>
                        </p>

                    </div>


                    <div class="admin-response">

                        <div class="admin-response-title">
                            Admin Response
                        </div>

                        <?php if (!empty($complaint["admin_response"])): ?>

                            <?php
                            echo nl2br(
                                htmlspecialchars($complaint["admin_response"])
                            );
                            ?>

                        <?php else: ?>

                            <span>
                                Your complaint is currently awaiting
                                administrative review.
                            </span>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="no-complaints">

                <h2>No Complaints Found</h2>

                <p>
                    You have not submitted any complaints yet.
                </p>

            </div>

        <?php endif; ?>

    </div>


    <!-- Navigation -->
    <div class="buttons">

        <a href="complaint_submit.php">
            Register New Complaint
        </a>

        <a href="student_dashboard.php">
            Back to Dashboard
        </a>

    </div>

</div>

</body>

</html>

<?php
$stmt->close();
?>