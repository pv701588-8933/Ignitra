<?php
session_start();

require_once "../../config/database.php";

// Student must be logged in
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: student_login.php");
    exit();
}

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION["user_id"];
    $feedback = trim($_POST["message"]);

    if (empty($feedback)) {

        $message = "Please enter your feedback.";
        $message_type = "error";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO feedback (user_id, message) VALUES (?, ?)"
        );

        $stmt->bind_param("is", $user_id, $feedback);

        if ($stmt->execute()) {

            $message = "Thank you! Your feedback has been submitted successfully.";
            $message_type = "success";

        } else {

            $message = "Unable to submit feedback. Please try again.";
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

    <title>Feedback | IGNITRA</title>

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
            padding: 40px 20px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 650px;
            margin: auto;
        }

        .box {
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
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
            margin-bottom: 28px;
            font-size: 14px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        textarea {
            width: 100%;
            min-height: 180px;
            padding: 13px;
            border: 1px solid #d8c8b7;
            border-radius: 8px;
            resize: vertical;
            font-family: Arial, sans-serif;
            font-size: 15px;
            outline: none;
        }

        textarea:focus {
            border-color: #d87532;
        }

        .submit-btn {
            width: 100%;
            margin-top: 18px;
            padding: 13px;
            border: none;
            border-radius: 7px;
            background: #d87532;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #c66325;
        }

        .message {
            padding: 12px;
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

<div class="container">

    <div class="box">

        <div class="logo">
            <img src="../../assets/images/ingitra.png" alt="IGNITRA">
        </div>

        <h1>Share Your Feedback</h1>

        <p class="subtitle">
            Help us improve your IGNITRA experience.
        </p>

        <?php if (!empty($message)): ?>

            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <label for="message">
                Your Feedback
            </label>

            <textarea
                id="message"
                name="message"
                placeholder="Write your feedback here..."
                required
            ></textarea>

            <button type="submit" class="submit-btn">
                Submit Feedback
            </button>

        </form>

        <div class="back">
            <a href="student_dashboard.php">
                ← Back to Dashboard
            </a>
        </div>

    </div>

</div>

</body>
</html>