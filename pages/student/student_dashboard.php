<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "student") {
    header("Location: student_login.php");
    exit();
}

$user_name = $_SESSION["user_name"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard | IGNITRA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7efe3;
            color: #333;
        }

        .navbar {
            background: #ffffff;
            padding: 15px 6%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .logo img {
            width: 130px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome {
            color: #555;
            font-size: 14px;
        }

        .logout {
            background: #d87532;
            color: white;
            text-decoration: none;
            padding: 9px 17px;
            border-radius: 6px;
            font-size: 14px;
        }

        .logout:hover {
            background: #c66325;
        }

        .container {
            width: 90%;
            max-width: 1150px;
            margin: 40px auto;
        }

        .hero {
            background: #fff;
            padding: 35px;
            border-radius: 14px;
            margin-bottom: 30px;
            box-shadow: 0 5px 18px rgba(0,0,0,0.07);
        }

        .hero h1 {
            color: #c65f21;
            margin-bottom: 10px;
            font-size: 30px;
        }

        .hero p {
            color: #666;
            line-height: 1.6;
        }

        .section-title {
            color: #c65f21;
            margin-bottom: 18px;
            font-size: 22px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.07);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card h3 {
            color: #c65f21;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .card a {
            display: inline-block;
            text-decoration: none;
            background: #d87532;
            color: white;
            padding: 9px 15px;
            border-radius: 6px;
            font-size: 13px;
        }

        .card a:hover {
            background: #c66325;
        }

        @media (max-width: 800px) {
            .cards {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 550px) {
            .navbar {
                padding: 15px 4%;
            }

            .welcome {
                display: none;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .container {
                width: 92%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <div class="logo">
            <a href="../../index.php">
                <img src="../../assets/images/ingitra.png" alt="IGNITRA">
            </a>
        </div>

        <div class="nav-right">
            <span class="welcome">
                Welcome, <?php echo htmlspecialchars($user_name); ?>
            </span>

            <a href="student_logout.php" class="logout">
                Logout
            </a>
        </div>

    </nav>


    <main class="container">

        <section class="hero">
            <h1>Welcome to your Dashboard</h1>

            <p>
                Access guidance, verified volunteers, communities,
                roadmaps, questions, feedback and support from one place.
            </p>
        </section>


        <h2 class="section-title">Student Services</h2>

        <div class="cards">

            <div class="card">
                <h3>Verified Volunteers</h3>

                <p>
                    Explore verified volunteers and find guidance
                    based on their expertise and experience.
                </p>

                <a href="volunteers.php">Explore Volunteers</a>
            </div>


            <div class="card">
                <h3>Communities</h3>

                <p>
                    Explore relevant student communities and
                    connect around shared interests.
                </p>

                <a href="communities.php">View Communities</a>
            </div>


            <div class="card">
                <h3>Roadmaps</h3>

                <p>
                    Access official learning and career roadmaps
                    provided through IGNITRA.
                </p>

                <a href="roadmaps.php">View Roadmaps</a>
            </div>


            <div class="card">
                <h3>Ask a Question</h3>

                <p>
                    Ask questions and seek guidance from
                    relevant volunteers.
                </p>

                <a href="questions.php">Ask Question</a>
            </div>


            <div class="card">
                <h3>Feedback</h3>

                <p>
                    Share your experience and provide feedback
                    about IGNITRA and its services.
                </p>

                <a href="feedback_submit.php">Give Feedback</a>
            </div>


            <div class="card">
                <h3>Complaints</h3>

                <p>
                    Register a complaint privately and track
                    its progress through the system.
                </p>

                <a href="complaint_submit.php">Register Complaint</a>
            </div>

        </div>

    </main>

</body>
</html>