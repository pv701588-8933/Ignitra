<?php
session_start();

require_once "../config/database.php";

/* Detect database connection variable */
if (isset($conn)) {
    $db = $conn;
} elseif (isset($connection)) {
    $db = $connection;
} elseif (isset($mysqli)) {
    $db = $mysqli;
} else {
    die("Database connection not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";

    } else {

        $stmt = $db->prepare(
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ? AND role = 'volunteer'
             LIMIT 1"
        );

        if (!$stmt) {
            die("Database error: " . $db->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["role"] = $user["role"];

                header("Location: volunteer_dashboard.php");
                exit;

            } else {
                $message = "Invalid email or password.";
            }

        } else {
            $message = "Volunteer account not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Volunteer Login - IGNITRA</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f7fb;
        }

        .container {
            width: 90%;
            max-width: 450px;
            margin: 80px auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
            color: #222;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            margin-top: 18px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        button {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #4f46e5;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #4338ca;
        }

        .message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 7px;
            text-align: center;
            margin-bottom: 20px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Volunteer Login</h1>

    <p class="subtitle">
        Login to your IGNITRA volunteer account.
    </p>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Email</label>

        <input
            type="email"
            name="email"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            required
        >

        <button type="submit">
            Login
        </button>

    </form>

    <div class="register-link">

        Don't have an account?
        <a href="volunteer_registration.php">
            Register as Volunteer
        </a>

    </div>

</div>

</body>
</html>