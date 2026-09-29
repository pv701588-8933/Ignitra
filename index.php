<?php
require_once "config/database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ignitra | Student Guidance Platform</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>


<!-- ================= NAVBAR ================= -->

<header class="navbar">

    <div class="brand">

        <img src="images/ignitra-logo.jpg" alt="Ignitra Logo">

        <div class="brand-text">
            <strong>IGNITRA</strong>
            <span>YOUTH COUNCIL</span>
        </div>

    </div>


    <nav>

        <a href="#home">Home</a>

        <a href="#guidance">Guidance</a>

        <a href="#volunteers">Volunteers</a>

        <a href="#communities">Communities</a>

        <a href="#experiences">Experiences</a>

        <a href="login.php" class="login-btn">Login</a>

    </nav>

</header>



<!-- ================= HERO ================= -->

<section class="hero" id="home">

    <div class="hero-content">

        <div class="eyebrow">
            GUIDANCE &nbsp; • &nbsp; LEARNING &nbsp; • &nbsp; GROWTH
        </div>

        <h1>
            Find your <span>path.</span><br>
            Build your <strong>future.</strong>
        </h1>

        <p>
            Confused about what to do next?
            Explore career roadmaps, discover guidance resources,
            connect with experienced volunteers and learn from real journeys.
        </p>


        <!-- SEARCH -->

        <form class="search-box" action="search.php" method="GET">

            <input
                type="text"
                name="q"
                placeholder="What are you looking for? e.g. BCA, Data Analytics..."
            >

            <button type="submit">
                Search
            </button>

        </form>


        <div class="popular-searches">

            <span>Popular:</span>

            <a href="#">BCA Roadmap</a>

            <a href="#">After 12th</a>

            <a href="#">Data Analytics</a>

            <a href="#">Career Guidance</a>

        </div>

    </div>


    <!-- HERO LOGO -->

    <div class="hero-logo">

        <img src="images/ignitra-logo.jpg" alt="Ignitra">

        <div class="hero-tagline">
            Better Guidance.<br>
            Brighter Futures.
        </div>

    </div>

</section>



<!-- ================= GUIDANCE ================= -->

<section class="section" id="guidance">

    <div class="section-heading">

        <div>
            <span class="section-label">EXPLORE</span>

            <h2>Guidance Resources</h2>
        </div>

        <p>
            Start with a roadmap designed to make your next step clearer.
        </p>

    </div>


    <div class="cards">


        <article class="card">

            <div class="icon orange">
                🎓
            </div>

            <h3>After 12th Roadmaps</h3>

            <p>
                Explore education and career paths after completing 12th.
            </p>

            <a href="#">
                Explore Roadmaps →
            </a>

        </article>


        <article class="card">

            <div class="icon green">
                💻
            </div>

            <h3>BCA Career Roadmap</h3>

            <p>
                Understand skills, career options, higher studies and opportunities after BCA.
            </p>

            <a href="#">
                View Roadmap →
            </a>

        </article>


        <article class="card">

            <div class="icon orange">
                📊
            </div>

            <h3>Data Analytics</h3>

            <p>
                Discover the skills and learning path required to enter data analytics.
            </p>

            <a href="#">
                View Roadmap →
            </a>

        </article>


    </div>

</section>



<!-- ================= VOLUNTEERS ================= -->

<section class="section light-section" id="volunteers">

    <div class="section-heading">

        <div>
            <span class="section-label">CONNECT</span>

            <h2>People Who Can Guide You</h2>
        </div>

        <p>
            Find volunteers based on their education, skills and experience.
        </p>

    </div>


    <div class="cards">


        <article class="card">

            <div class="icon orange">
                👩‍💻
            </div>

            <h3>Career Guidance</h3>

            <p>
                Connect with people who have relevant academic and professional experience.
            </p>

            <a href="#">
                Find Volunteers →
            </a>

        </article>


        <article class="card">

            <div class="icon green">
                📚
            </div>

            <h3>Skill Guidance</h3>

            <p>
                Discover people who can guide you about practical skills and learning paths.
            </p>

            <a href="#">
                Explore Skills →
            </a>

        </article>


        <article class="card">

            <div class="icon orange">
                💬
            </div>

            <h3>Ask a Question</h3>

            <p>
                Have a specific doubt? Ask your question and get guidance from an approved volunteer.
            </p>

            <a href="register.php">
                Get Started →
            </a>

        </article>


    </div>

</section>



<!-- ================= COMMUNITIES ================= -->

<section class="section" id="communities">

    <div class="section-heading">

        <div>
            <span class="section-label">COMMUNITY</span>

            <h2>Learn Together</h2>
        </div>

        <p>
            Join communities with students and volunteers interested in similar areas.
        </p>

    </div>


    <div class="cards">


        <article class="card">

            <div class="icon green">
                👥
            </div>

            <h3>BCA & Tech Community</h3>

            <p>
                Discuss programming, projects, internships and technology careers.
            </p>

            <a href="#">
                View Community →
            </a>

        </article>


        <article class="card">

            <div class="icon orange">
                📈
            </div>

            <h3>Data Analytics</h3>

            <p>
                Learn and discuss Excel, SQL, Power BI and analytics careers.
            </p>

            <a href="#">
                View Community →
            </a>

        </article>


        <article class="card">

            <div class="icon green">
                🚀
            </div>

            <h3>Career Exploration</h3>

            <p>
                Explore different career options and share learning experiences.
            </p>

            <a href="#">
                View Community →
            </a>

        </article>


    </div>

</section>



<!-- ================= EXPERIENCES ================= -->

<section class="section light-section" id="experiences">

    <div class="section-heading">

        <div>
            <span class="section-label">REAL STORIES</span>

            <h2>Learn From Real Experiences</h2>
        </div>

        <p>
            Discover journeys from people who have already taken the path.
        </p>

    </div>


    <div class="cards">


        <article class="experience-card">

            <span>CAREER JOURNEY</span>

            <h3>
                BCA → Data Analyst
            </h3>

            <p>
                Discover how a student built skills and moved toward a career in data analytics.
            </p>

            <a href="#">
                Read Experience →
            </a>

        </article>


        <article class="experience-card">

            <span>TECHNOLOGY</span>

            <h3>
                From Student to Developer
            </h3>

            <p>
                Learn about practical learning, projects and the transition into development.
            </p>

            <a href="#">
                Read Experience →
            </a>

        </article>


        <article class="experience-card">

            <span>CAREER CHOICE</span>

            <h3>
                Choosing the Right Career
            </h3>

            <p>
                Explore real experiences that can help you understand different career paths.
            </p>

            <a href="#">
                Read Experience →
            </a>

        </article>


    </div>

</section>



<!-- ================= CTA ================= -->

<section class="cta">

    <div>

        <span>NOT SURE WHERE TO START?</span>

        <h2>
            Your next step can start with one question.
        </h2>

        <p>
            Explore resources or ask someone who has already walked the path.
        </p>

    </div>


    <a href="register.php">
        Start Exploring →
    </a>

</section>



<!-- ================= FOOTER ================= -->

<footer>

    <div class="footer-brand">

        <div class="footer-logo">
            IGNITRA
        </div>

        <p>
            Better Guidance. Brighter Futures.
        </p>

    </div>


    <div class="footer-links">

        <a href="#">About</a>

        <a href="#">Guidance</a>

        <a href="#">Volunteers</a>

        <a href="#">Communities</a>

        <a href="#">Feedback</a>

        <a href="#">Complaints</a>

    </div>


    <div class="copyright">

        © 2026 Ignitra. Student Guidance Platform.

    </div>

</footer>


</body>

</html>