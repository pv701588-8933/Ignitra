<?php
session_start();

require_once "../../config/database.php";

// Admin authentication
if (!isset($_SESSION["admin_id"]) || $_SESSION["admin_role"] !== "admin") {
    header("Location: admin_login.php");
    exit();
}

$message = "";
$message_type = "";

/*
|--------------------------------------------------------------------------
| UPDATE COMPLAINT
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_complaint"])) {

    $complaint_id = trim($_POST["complaint_id"]);
    $status = trim($_POST["status"]);
    $admin_response = trim($_POST["admin_response"]);

    if (empty($complaint_id) || empty($status)) {

        $message = "Complaint ID and status are required.";
        $message_type = "error";

    } else {

        $stmt = $conn->prepare("
            UPDATE complaints
            SET status = ?,
                admin_response = ?,
                updated_at = NOW()
            WHERE complaint_id = ?
        ");

        $stmt->bind_param(
            "sss",
            $status,
            $admin_response,
            $complaint_id
        );

        if ($stmt->execute()) {

            $message = "Complaint updated successfully.";
            $message_type = "success";

        } else {

            $message = "Unable to update complaint.";
            $message_type = "error";
        }

        $stmt->close();
    }
}


/*
|--------------------------------------------------------------------------
| FETCH ALL COMPLAINTS
|--------------------------------------------------------------------------
*/

$result = $conn->query("
    SELECT
        c.complaint_id,
        c.user_id,
        c.category,
        c.related_module,
        c.description,
        c.status,
        c.admin_response,
        c.created_at,
        c.updated_at,
        u.name,
        u.email
    FROM complaints c
    LEFT JOIN users u
        ON c.user_id = u.id
    ORDER BY c.created_at DESC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Complaint Management | IGNITRA</title>

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
        }

        /* NAVBAR */

        .navbar {
            background: #ffffff;
            padding: 14px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
        }

        .logo img {
            width: 125px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-name {
            color: #555;
            font-size: 14px;
        }

        .dashboard-link,
        .logout {
            text-decoration: none;
            color: #ffffff;
            background: #d87532;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 13px;
        }

        .dashboard-link:hover,
        .logout:hover {
            background: #c66325;
        }

        /* MAIN */

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 35px 25px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            color: #c65f21;
            margin-bottom: 7px;
        }

        .page-header p {
            color: #666;
            font-size: 14px;
        }

        /* MESSAGE */

        .message {
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .success {
            background: #edf5e8;
            color: #4f6f35;
        }

        .error {
            background: #fce8df;
            color: #a43f16;
        }

        /* COMPLAINT CARD */

        .complaint-card {
            background: #ffffff;
            border-radius: 13px;
            padding: 25px;
            margin-bottom: 22px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .complaint-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .complaint-id {
            color: #c65f21;
            font-size: 17px;
            font-weight: bold;
        }

        .status {
            padding: 7px 14px;
            border-radius: 20px;
            background: #f4e4d4;
            color: #9a551f;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
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

        /* USER INFO */

        .user-info {
            background: #faf6f0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .user-info strong {
            color: #c65f21;
        }

        .user-info p {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }

        /* DETAILS */

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 13px;
            margin-bottom: 18px;
        }

        .detail {
            background: #faf6f0;
            padding: 13px;
            border-radius: 7px;
        }

        .detail-label {
            display: block;
            font-size: 12px;
            font-weight: bold;
            color: #777;
            margin-bottom: 5px;
        }

        /* DESCRIPTION */

        .description {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .description-title {
            color: #c65f21;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* FORM */

        .update-box {
            border-top: 1px solid #eee3d7;
            padding-top: 20px;
        }

        .update-box h3 {
            color: #c65f21;
            margin-bottom: 15px;
            font-size: 17px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 7px;
        }

        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d8c8b7;
            border-radius: 7px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            outline: none;
        }

        select:focus,
        textarea:focus {
            border-color: #d87532;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .update-btn {
            background: #d87532;
            color: #ffffff;
            border: none;
            padding: 11px 20px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .update-btn:hover {
            background: #c66325;
        }

        .no-complaints {
            background: #ffffff;
            padding: 50px;
            border-radius: 12px;
            text-align: center;
            color: #666;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        @media (max-width: 700px) {

            .navbar {
                padding: 14px 18px;
            }

            .admin-name {
                display: none;
            }

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


<!-- NAVBAR -->

<nav class="navbar">

    <div class="logo">

        <img
            src="../../assets/images/ingitra.png"
            alt="IGNITRA"
        >

    </div>


    <div class="nav-right">

        <span class="admin-name">

            <?php
            echo htmlspecialchars($_SESSION["admin_name"]);
            ?>

        </span>


        <a
            href="admin_dashboard.php"
            class="dashboard-link"
        >
            Dashboard
        </a>


        <a
            href="admin_logout.php"
            class="logout"
        >
            Logout
        </a>

    </div>

</nav>


<!-- MAIN -->

<div class="container">


    <div class="page-header">

        <h1>
            Complaint Management
        </h1>

        <p>
            Review complaints and update their status and response.
        </p>

    </div>


    <!-- MESSAGE -->

    <?php if (!empty($message)): ?>

        <div class="message <?php echo $message_type; ?>">

            <?php
            echo htmlspecialchars($message);
            ?>

        </div>

    <?php endif; ?>


    <!-- COMPLAINTS -->

    <?php if ($result->num_rows > 0): ?>


        <?php while ($complaint = $result->fetch_assoc()): ?>

            <?php

            $status_class = strtolower(
                str_replace(
                    " ",
                    "_",
                    $complaint["status"]
                )
            );

            ?>


            <div class="complaint-card">


                <!-- HEADER -->

                <div class="complaint-header">

                    <div class="complaint-id">

                        <?php
                        echo htmlspecialchars(
                            $complaint["complaint_id"]
                        );
                        ?>

                    </div>


                    <div class="status <?php echo htmlspecialchars($status_class); ?>">

                        <?php
                        echo htmlspecialchars(
                            $complaint["status"]
                        );
                        ?>

                    </div>

                </div>


                <!-- USER -->

                <div class="user-info">

                    <strong>
                        Submitted By
                    </strong>

                    <p>

                        <?php
                        echo htmlspecialchars(
                            $complaint["name"] ?? "Unknown User"
                        );
                        ?>

                        &nbsp; | &nbsp;

                        <?php
                        echo htmlspecialchars(
                            $complaint["email"] ?? "No email"
                        );
                        ?>

                    </p>

                </div>


                <!-- DETAILS -->

                <div class="details">


                    <div class="detail">

                        <span class="detail-label">
                            Category
                        </span>

                        <?php
                        echo htmlspecialchars(
                            $complaint["category"]
                        );
                        ?>

                    </div>


                    <div class="detail">

                        <span class="detail-label">
                            Related Module
                        </span>

                        <?php
                        echo htmlspecialchars(
                            $complaint["related_module"]
                        );
                        ?>

                    </div>


                    <div class="detail">

                        <span class="detail-label">
                            Submitted On
                        </span>

                        <?php
                        echo htmlspecialchars(
                            $complaint["created_at"]
                        );
                        ?>

                    </div>


                    <div class="detail">

                        <span class="detail-label">
                            Last Updated
                        </span>

                        <?php
                        echo htmlspecialchars(
                            $complaint["updated_at"]
                        );
                        ?>

                    </div>


                </div>


                <!-- DESCRIPTION -->

                <div class="description">

                    <div class="description-title">
                        Complaint Description
                    </div>

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $complaint["description"]
                        )
                    );
                    ?>

                </div>


                <!-- UPDATE -->

                <div class="update-box">

                    <h3>
                        Update Complaint
                    </h3>


                    <form method="POST">


                        <input
                            type="hidden"
                            name="complaint_id"
                            value="<?php echo htmlspecialchars($complaint["complaint_id"]); ?>"
                        >


                        <div class="form-group">

                            <label>
                                Complaint Status
                            </label>

                            <select name="status" required>

                                <option
                                    value="submitted"
                                    <?php
                                    echo $complaint["status"] === "submitted"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Submitted
                                </option>

                                <option
                                    value="in progress"
                                    <?php
                                    echo $complaint["status"] === "in progress"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    In Progress
                                </option>

                                <option
                                    value="resolved"
                                    <?php
                                    echo $complaint["status"] === "resolved"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Resolved
                                </option>

                                <option
                                    value="closed"
                                    <?php
                                    echo $complaint["status"] === "closed"
                                        ? "selected"
                                        : "";
                                    ?>
                                >
                                    Closed
                                </option>

                            </select>

                        </div>


                        <div class="form-group">

                            <label>
                                Admin Response
                            </label>

                            <textarea
                                name="admin_response"
                                placeholder="Write a response for the student..."
                            ><?php
                            echo htmlspecialchars(
                                $complaint["admin_response"] ?? ""
                            );
                            ?></textarea>

                        </div>


                        <button
                            type="submit"
                            name="update_complaint"
                            class="update-btn"
                        >
                            Update Complaint
                        </button>


                    </form>

                </div>


            </div>


        <?php endwhile; ?>


    <?php else: ?>


        <div class="no-complaints">

            <h2>
                No Complaints Found
            </h2>

            <p>
                There are currently no complaints in the system.
            </p>

        </div>


    <?php endif; ?>


</div>

</body>

</html>