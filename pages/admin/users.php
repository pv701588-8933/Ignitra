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
   FETCH USERS
========================= */

$users_result = $conn->query("
    SELECT
        id,
        name,
        email,
        role,
        created_at
    FROM users
    ORDER BY created_at DESC
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

    <title>Manage Users - IGNITRA</title>

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
           USER TABLE
        ========================= */

        .table-container {
            background: #ffffff;
            border-radius: 10px;

            box-shadow: 0 3px 12px rgba(0,0,0,0.08);

            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1e3d1;
            color: #7a3e00;

            text-align: left;

            padding: 15px;
            font-size: 14px;
        }

        td {
            padding: 15px;

            border-bottom: 1px solid #eee;

            color: #444;

            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #fffaf4;
        }

        /* =========================
           ROLE BADGES
        ========================= */

        .role {
            display: inline-block;

            padding: 6px 12px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: bold;

            text-transform: capitalize;
        }

        .role.student {
            background: #fff0dd;
            color: #a65300;
        }

        .role.volunteer {
            background: #f4eadc;
            color: #7a3e00;
        }

        .role.admin {
            background: #eadcc9;
            color: #6b3900;
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

            th,
            td {
                padding: 11px;
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
        User Management
    </h1>

    <p class="subtitle">
        View registered students, volunteers and administrators.
    </p>


    <?php if ($users_result && $users_result->num_rows > 0): ?>

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Name
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Registered On
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php while ($user = $users_result->fetch_assoc()): ?>

                        <?php
                        $role = strtolower(
                            $user["role"] ?? "user"
                        );
                        ?>

                        <tr>

                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $user["id"]
                                );
                                ?>
                            </td>


                            <td>
                                <strong>
                                    <?php
                                    echo htmlspecialchars(
                                        $user["name"]
                                    );
                                    ?>
                                </strong>
                            </td>


                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $user["email"]
                                );
                                ?>
                            </td>


                            <td>

                                <span class="role <?php
                                    echo htmlspecialchars($role);
                                ?>">

                                    <?php
                                    echo htmlspecialchars(
                                        ucfirst($role)
                                    );
                                    ?>

                                </span>

                            </td>


                            <td>
                                <?php
                                echo htmlspecialchars(
                                    $user["created_at"]
                                );
                                ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="empty">

            <h3>
                No Users Found
            </h3>

            <p>
                There are currently no registered users.
            </p>

        </div>

    <?php endif; ?>

</div>


</body>

</html>