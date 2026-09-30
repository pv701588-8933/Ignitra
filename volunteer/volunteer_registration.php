<?php
session_start();

require_once "../config/database.php";

/* Use whichever database connection variable exists */
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
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name       = trim($_POST["name"]);
    $email      = trim($_POST["email"]);
    $password   = $_POST["password"];
    $education  = trim($_POST["education"]);
    $profession = trim($_POST["profession"]);
    $skills     = trim($_POST["skills"]);
    $expertise  = trim($_POST["expertise"]);
    $bio        = trim($_POST["bio"]);

    if (empty($name) || empty($email) || empty($password)) {
        $message = "Please fill all required fields.";
        $message_type = "error";
    } else {

        /* Check existing email */
        $check = $db->prepare("SELECT id FROM users WHERE email = ?");

        if (!$check) {
            die("Database error: " . $db->error);
        }

        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "This email is already registered.";
            $message_type = "error";

        } else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            /* Create user */
            $stmt = $db->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, 'volunteer')"
            );

            if (!$stmt) {
                die("Database error: " . $db->error);
            }

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {

                $user_id = $stmt->insert_id;

                /* Create volunteer profile */
                $profile = $db->prepare(
                    "INSERT INTO volunteer_profiles
                    (user_id, education, profession, skills, expertise, bio, status)
                    VALUES (?, ?, ?, ?, ?, ?, 'pending')"
                );

                if (!$profile) {
                    die("Profile database error: " . $db->error);
                }

                $profile->bind_param(
                    "isssss",
                    $user_id,
                    $education,
                    $profession,
                    $skills,
                    $expertise,
                    $bio
                );

                if ($profile->execute()) {

                    $message = "Registration successful! You can now login.";
                    $message_type = "success";

                } else {

                    $message = "Registration completed, but profile creation failed.";
                    $message_type = "error";
                }

            } else {

                $message = "Registration failed. Please try again.";
                $message_type = "error";
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

    <title>Volunteer Registration - IGNITRA</title>

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
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            color: #222;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
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
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 7px;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #4f46e5;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Volunteer Registration</h1>

    <p class="subtitle">
        Join IGNITRA as a volunteer and help the community.
    </p>

    <?php if (!empty($message)): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Full Name *</label>
        <input
            type="text"
            name="name"
            required
        >

        <label>Email *</label>
        <input
            type="email"
            name="email"
            required
        >

        <label>Password *</label>
        <input
            type="password"
            name="password"
            required
        >

        <label>Education</label>
        <input
            type="text"
            name="education"
            placeholder="e.g. BCA, B.Tech, MBA"
        >

        <label>Profession</label>
        <input
            type="text"
            name="profession"
            placeholder="e.g. Student, Teacher, Developer"
        >

        <label>Skills</label>
        <input
            type="text"
            name="skills"
            placeholder="e.g. Teaching, Coding, Communication"
        >

        <label>Expertise</label>
        <input
            type="text"
            name="expertise"
            placeholder="Area in which you can help"
        >

        <label>Short Bio</label>
        <textarea
            name="bio"
            placeholder="Tell us briefly about yourself..."
        ></textarea>

        <button type="submit">
            Register as Volunteer
        </button>

    </form>

    <div class="login-link">
        Already registered?
        <a href="login.php">Login here</a>
    </div>

</div>

</body>
</html>