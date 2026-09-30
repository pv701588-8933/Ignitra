<?php
require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        $message = "Please fill all fields.";
    } else {

        // Check whether email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $message = "An account with this email already exists.";
        } else {

            // Secure password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // New users are students by default
            $role = "student";

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashedPassword,
                $role
            );

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | Ignitra</title>

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
        <a href="login.php">Login</a>
    </nav>

</header>


<section class="section">

    <div style="max-width: 500px; margin: 40px auto;">

        <div class="section-heading">
            <div>
                <span class="section-label">JOIN IGNITRA</span>
                <h2>Create Your Account</h2>
            </div>
        </div>

        <?php if (!empty($message)): ?>

            <p style="color: #b95105; margin-bottom: 20px;">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>


        <form method="POST" class="card">

            <label>Name</label>

            <input
                type="text"
                name="name"
                placeholder="Enter your name"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >


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
                placeholder="Create a password"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >


            <button
                type="submit"
                class="login-btn"
                style="border:none; cursor:pointer; padding:12px 24px;"
            >
                Create Account
            </button>

        </form>


        <p style="margin-top:20px;">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</section>


</body>
</html>