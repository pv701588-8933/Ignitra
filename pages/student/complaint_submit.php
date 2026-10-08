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
    $category = trim($_POST["category"]);
    $related_module = trim($_POST["related_module"]);
    $description = trim($_POST["description"]);

    if (empty($category) || empty($related_module) || empty($description)) {

        $message = "Please fill in all fields.";
        $message_type = "error";

    } else {

        // Generate unique complaint ID
        $complaint_id = "IGN-CMP-" . strtoupper(bin2hex(random_bytes(3)));

        $status = "submitted";

        $stmt = $conn->prepare(
            "INSERT INTO complaints
            (complaint_id, user_id, category, related_module, description, status)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sissss",
            $complaint_id,
            $user_id,
            $category,
            $related_module,
            $description,
            $status
        );

        if ($stmt->execute()) {

            $message = "Complaint submitted successfully. Your Complaint ID is " . $complaint_id;
            $message_type = "success";

        } else {

            $message = "Unable to submit complaint. Please try again.";
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

    <title>Register Complaint | IGNITRA</title>

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
            max-width: 700px;
            margin: auto;
        }

        .box {
            background: #fff;
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
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d8c8b7;
            border-radius: 8px;
            font-size: 15px;
            font-family: Arial, sans-serif;
            outline: none;
        }

        select:focus,
        textarea:focus {
            border-color: #d87532;
        }

        textarea {
            min-height: 170px;
            resize: vertical;
        }

        .submit-btn {
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

        .submit-btn:hover {
            background: #c66325;
        }

        .message {
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            line-height: 1.5;
        }

        .success {
            background: #edf5e8;
            color: #4f6f35;
        }

        .error {
            background: #fce8df;
            color: #a43f16;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #c65f21;
            text-decoration: none;
            font-size: 14px;
            margin: 0 8px;
        }

        .links a:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="box">

        <div class="logo">
            <img src="../../assets/images/ingitra.png" alt="IGNITRA">
        </div>

        <h1>Register a Complaint</h1>

        <p class="subtitle">
            Submit your complaint privately. Your complaint will be reviewed
            by the IGNITRA administration team.
        </p>

        <?php if (!empty($message)): ?>

            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="form-group">

                <label for="category">
                    Complaint Category
                </label>

                <select id="category" name="category" required>

                    <option value="">Select Category</option>

                    <option value="Technical Issue">
                        Technical Issue
                    </option>

                    <option value="Account">
                        Account
                    </option>

                    <option value="Volunteer">
                        Volunteer
                    </option>

                    <option value="Guidance">
                        Guidance
                    </option>

                    <option value="Roadmap">
                        Roadmap
                    </option>

                    <option value="Community">
                        Community
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="related_module">
                    Related Module
                </label>

                <select id="related_module" name="related_module" required>

                    <option value="">Select Module</option>

                    <option value="Account">
                        Account
                    </option>

                    <option value="Volunteers">
                        Volunteers
                    </option>

                    <option value="Communities">
                        Communities
                    </option>

                    <option value="Roadmaps">
                        Roadmaps
                    </option>

                    <option value="Questions">
                        Questions & Answers
                    </option>

                    <option value="Experiences">
                        Experiences
                    </option>

                    <option value="Guidance">
                        Guidance
                    </option>

                    <option value="Technical">
                        Technical
                    </option>

                    <option value="Other">
                        Other
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="description">
                    Complaint Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Describe your complaint clearly..."
                    required
                ></textarea>

            </div>


            <button type="submit" class="submit-btn">
                Submit Complaint
            </button>

        </form>


        <div class="links">

            <a href="complaint_track.php">
                Track My Complaints
            </a>

            <a href="student_dashboard.php">
                Back to Dashboard
            </a>

        </div>

    </div>

</div>

</body>
</html>