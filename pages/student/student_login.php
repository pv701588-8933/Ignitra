<?php
session_start();
require_once "../../config/database.php";

$message = "";
$message_type = "";

// Show registration success message
if (isset($_GET["registered"]) && $_GET["registered"] == "1") {
    $message = "Registration successful! Please login.";
    $message_type = "success";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $message = "Please enter your email and password.";
        $message_type = "error";
    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password, role 
             FROM users 
             WHERE email = ? AND role = 'student'
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                // Create student session
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_role"] = $user["role"];

                header("Location: student_dashboard.php");
                exit();

            } else {
                $message = "Incorrect email or password.";
                $message_type = "error";
            }

        } else {
            $message = "Incorrect email or password.";
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

    <title>Student Login | IGNITRA</title>

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
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.10);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            width: 150px;
            max-width: 100%;
        }

        h1 {
            text-align: center;
            color: #c65f21;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d8c8b7;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #d87532;
        }

        .login-btn {
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

        .login-btn:hover {
            background: #c66325;
        }

        .message {
            padding: 11px;
            border-radius: 6px;
            margin-bottom: 18px;
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

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .register-link a {
            color: #c65f21;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            text-align: center;
            margin-top: 15px;
        }

        .back-home a {
            color: #666;
            text-decoration: none;
            font-size: 13px;
        }

        .back-home a:hover {
            color: #c65f21;
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="logo">
        <img src="../../assets/images/ingitra.png" alt="IGNITRA">
    </div>

    <h1>Student Login</h1>

    <p class="subtitle">
        Login to access your IGNITRA dashboard
    </p>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">

        <div class="form-group">
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="login-btn">
            Login
        </button>

    </form>

    <div class="register-link">
        Don't have an account?
        <a href="student_register.php">Register here</a>
    </div>

    <div class="back-home">
        <a href="../../index.php">← Back to IGNITRA Home</a>
    </div>

</div>

</body>
</html>