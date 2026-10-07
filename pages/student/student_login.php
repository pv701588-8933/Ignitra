<?php

session_start();
require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                $_SESSION["email"] = $user["email"];
                $_SESSION["role"] = $user["role"];


                /*
                 * Redirect user according to their role
                 */

                if ($user["role"] === "admin") {

                    header("Location: admin/dashboard.php");

                } elseif ($user["role"] === "volunteer") {

                    header("Location: volunteer/dashboard.php");

                } else {

                    header("Location: dashboard.php");

                }

                exit;

            } else {

                $message = "Incorrect email or password.";
            }

        } else {

            $message = "Incorrect email or password.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Ignitra</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<header class="navbar">

    <div class="brand">

        <img src="images/ignitra-logo.jpg" alt="Ignitra Logo">

        <div class="brand-text">

            <strong>IGNITRA</strong>

            <span>YOUTH COUNCIL</span>

        </div>

    </div>

    <nav>

        <a href="index.php">Home</a>

        <a href="register.php">Register</a>

    </nav>

</header>


<section class="section">

    <div style="max-width: 500px; margin: 40px auto;">

        <div class="section-heading">

            <div>

                <span class="section-label">WELCOME BACK</span>

                <h2>Login to Ignitra</h2>

            </div>

        </div>


        <?php if (!empty($message)): ?>

            <p style="color: #b95105; margin-bottom: 20px;">

                <?php echo htmlspecialchars($message); ?>

            </p>

        <?php endif; ?>


        <?php if (isset($_GET["registered"])): ?>

            <p style="color: #466b32; margin-bottom: 20px;">

                Account created successfully. Please login.

            </p>

        <?php endif; ?>


        <form method="POST" class="card">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >


            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >


            <button
                type="submit"
                class="login-btn"
                style="border:none; cursor:pointer; padding:12px 24px;"
            >
                Login
            </button>

        </form>


        <p style="margin-top:20px;">

            Don't have an account?

            <a href="register.php">Create one</a>

        </p>

    </div>

</section>


</body>

</html>