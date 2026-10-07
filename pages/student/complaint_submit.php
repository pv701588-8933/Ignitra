<?php
session_start();
require_once "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $category = trim($_POST["category"]);
    $related_module = trim($_POST["related_module"]);
    $description = trim($_POST["description"]);

    if (empty($category) || empty($related_module) || empty($description)) {

        $message = "Please fill all fields.";

    } else {

        // Generate complaint ID
        $complaint_id = "IGN-CMP-" . strtoupper(substr(uniqid(), -6));

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

            header(
                "Location: complaint_track.php?id=" .
                urlencode($complaint_id)
            );

            exit;

        } else {

            $message = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register Complaint | Ignitra</title>

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

        <a href="dashboard.php">Dashboard</a>

        <a href="logout.php">Logout</a>

    </nav>

</header>


<section class="section">

    <div style="max-width: 650px; margin: 40px auto;">

        <span class="section-label">SUPPORT</span>

        <h1>Register a Complaint</h1>

        <p>
            Tell us about the issue you are facing and our administration
            team will review it.
        </p>


        <?php if (!empty($message)): ?>

            <p style="color:#b95105;">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>


        <form method="POST" class="card">

            <label>Complaint Category</label>

            <select
                name="category"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >

                <option value="">Select category</option>

                <option value="Account">Account</option>

                <option value="Guidance">Guidance</option>

                <option value="Volunteer">Volunteer</option>

                <option value="Community">Community</option>

                <option value="Technical Issue">Technical Issue</option>

                <option value="Other">Other</option>

            </select>


            <label>Related Module</label>

            <select
                name="related_module"
                required
                style="width:100%; padding:12px; margin:8px 0 18px;"
            >

                <option value="">Select module</option>

                <option value="Guidance Resources">
                    Guidance Resources
                </option>

                <option value="Questions & Guidance">
                    Questions & Guidance
                </option>

                <option value="Volunteers">
                    Volunteers
                </option>

                <option value="Communities">
                    Communities
                </option>

                <option value="Experiences">
                    Experiences
                </option>

                <option value="Account">
                    Account
                </option>

                <option value="Other">
                    Other
                </option>

            </select>


            <label>Describe your complaint</label>

            <textarea
                name="description"
                rows="6"
                placeholder="Explain the issue clearly..."
                required
                style="width:100%; padding:12px; margin:8px 0 20px;"
            ></textarea>


            <button
                type="submit"
                class="login-btn"
                style="border:none; cursor:pointer; padding:12px 24px;"
            >
                Submit Complaint
            </button>

        </form>

    </div>

</section>

</body>

</html>