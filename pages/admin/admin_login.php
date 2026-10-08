<?php
session_start();

require_once "../../config/database.php";

$message = "";
$message_type = "";

if (isset($_SESSION["admin_id"])) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";
        $message_type = "error";

    } else {

        $stmt = $conn->prepare("
            SELECT id, name, email, password, role
            FROM users
            WHERE email = ? AND role = 'admin'
            LIMIT 1
        ");

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin["password"])) {

                $_SESSION["admin_id"] = $admin["id"];
                $_SESSION["admin_name"] = $admin["name"];
                $_SESSION["admin_email"] = $admin["email"];
                $_SESSION["admin_role"] = $admin["role"];

                header("Location: admin_dashboard.php");
                exit();

            } else {

                $message = "Invalid email or password.";
                $message_type = "error";
            }

        } else {

            $message = "Admin account not found.";
            $message_type = "error";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | IGNITRA</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7efe3;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }

        .login-box {
            width: 100%;
            max-width: 430px;
            background: #fff;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 7px 25px rgba(0,0,0,0.09);
        }

        .logo {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo img {
            width: 145px;
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
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d8c8b7;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #d87532;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #d87532;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #c66325;
        }

        .message {
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }

        .error {
            background: #fce8df;
            color: #a43f16;
        }

        .back {
            text-align: center;
            margin-top: 20px;
        }

        .back a {
            color: #c65f21;
            text-decoration: none;
            font-size: 14px;
        }

    </style>

</head>

<body>

<div class="login-box">

    <div class="logo">
        <img src="../../assets/images/ingitra.png" alt="IGNITRA">
    </div>

    <h1>Admin Login</h1>

    <p class="subtitle">
        Sign in to manage the IGNITRA platform.
    </p>

    <?php if (!empty($message)): ?>

        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter admin email"
                required
            >

        </div>


        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter admin password"
                required
            >

        </div>


        <button type="submit">
            Login as Admin
        </button>

    </form>


    <div class="back">

        <a href="../../index.php">
            ← Back to IGNITRA Home
        </a>

    </div>

</div>

</body>

</html>