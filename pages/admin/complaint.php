<?php

session_start();

require_once "../config/database.php";


// Admin access protection
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}


// Fetch all complaints
$sql = "SELECT
            complaints.id,
            complaints.complaint_id,
            complaints.category,
            complaints.related_module,
            complaints.description,
            complaints.status,
            complaints.admin_response,
            complaints.created_at,
            users.name,
            users.email
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        ORDER BY complaints.created_at DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Complaints | Ignitra</title>

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

        <h1>Complaint Management</h1>

        <p>
            View and manage complaints submitted by students.
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
                                Complaint ID
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Student
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Category
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Module
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Status
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Date
                            </th>

                            <th style="padding:12px; border-bottom:1px solid #ddd;">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        <?php while ($complaint = $result->fetch_assoc()): ?>

                            <tr>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $complaint["complaint_id"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <strong>
                                        <?php
                                        echo htmlspecialchars(
                                            $complaint["name"]
                                        );
                                        ?>
                                    </strong>

                                    <br>

                                    <small>
                                        <?php
                                        echo htmlspecialchars(
                                            $complaint["email"]
                                        );
                                        ?>
                                    </small>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $complaint["category"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $complaint["related_module"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $complaint["status"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <?php
                                    echo htmlspecialchars(
                                        $complaint["created_at"]
                                    );
                                    ?>

                                </td>


                                <td style="padding:12px; border-bottom:1px solid #eee;">

                                    <a
                                        href="complaint_view.php?id=<?php echo $complaint["id"]; ?>"
                                        class="btn"
                                    >
                                        View

                                    </a>

                                </td>


                            </tr>

                        <?php endwhile; ?>


                    </tbody>

                </table>

            </div>


        <?php else: ?>


            <div class="card">

                <h2>No Complaints Found</h2>

                <p>
                    There are currently no complaints submitted by students.
                </p>

            </div>


        <?php endif; ?>


    </section>


</main>


</body>

</html>