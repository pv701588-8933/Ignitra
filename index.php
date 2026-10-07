<?php
// IGNITRA - Public Home Page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>IGNITRA | Guidance. Experience. Growth.</title>

    <meta name="description"
          content="IGNITRA connects students with verified volunteers, guidance resources, roadmaps, communities and practical experiences.">

    <style>
        /* =========================================================
           IGNITRA THEME
           Existing beige + orange visual identity
        ========================================================= */

        :root {
            --beige: #f7eee3;
            --light-beige: #fff9f2;
            --cream: #fdf7ef;
            --orange: #d8753b;
            --dark-orange: #bd5d27;
            --soft-orange: #f2c5a5;
            --brown: #3e2b21;
            --text: #5a463a;
            --muted: #816f63;
            --white: #ffffff;
            --border: #ead8c7;
            --shadow: 0 10px 30px rgba(74, 47, 31, 0.08);
            --radius: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: var(--light-beige);
            color: var(--brown);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        /* =========================================================
           NAVBAR
        ========================================================= */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;

            width: 100%;
            background: rgba(255, 249, 242, 0.96);
            backdrop-filter: blur(10px);

            border-bottom: 1px solid var(--border);
        }

        .nav-container {
            max-width: 1200px;
            margin: auto;

            height: 76px;
            padding: 0 28px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Project logo - no project name beside it */
        .logo-link {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 52px;
            height: 52px;

            flex-shrink: 0;
        }

        .logo-link img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a {
            color: var(--text);
            font-size: 14px;
            font-weight: 600;

            position: relative;
            transition: 0.25s ease;
        }

        .nav-links a:hover {
            color: var(--orange);
        }

        .nav-links a::after {
            content: "";
            position: absolute;

            left: 0;
            bottom: -7px;

            width: 0;
            height: 2px;

            background: var(--orange);
            transition: 0.25s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 11px 19px;
            border-radius: 10px;

            font-size: 14px;
            font-weight: 700;

            transition: 0.25s ease;
            cursor: pointer;
        }

        .btn-outline {
            border: 1px solid var(--orange);
            color: var(--orange);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--orange);
            color: var(--white);
        }

        .btn-primary {
            background: var(--orange);
            color: var(--white);
            border: 1px solid var(--orange);
        }

        .btn-primary:hover {
            background: var(--dark-orange);
            border-color: var(--dark-orange);
            transform: translateY(-1px);
        }

        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            background:
                radial-gradient(circle at 85% 20%, rgba(216, 117, 59, 0.12), transparent 30%),
                linear-gradient(135deg, var(--light-beige), var(--beige));

            min-height: calc(100vh - 76px);

            display: flex;
            align-items: center;
        }

        .hero-container {
            max-width: 1200px;
            width: 100%;
            margin: auto;

            padding: 80px 28px;

            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 70px;
            align-items: center;
        }

        .hero-content {
            max-width: 650px;
        }

        .eyebrow {
            display: inline-block;

            padding: 7px 13px;
            margin-bottom: 22px;

            border-radius: 30px;

            background: rgba(216, 117, 59, 0.11);
            color: var(--dark-orange);

            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero h1 {
            font-size: clamp(42px, 5vw, 68px);
            line-height: 1.05;
            margin-bottom: 22px;
            color: var(--brown);
        }

        .hero h1 span {
            color: var(--orange);
        }

        .hero p {
            color: var(--muted);
            font-size: 18px;
            max-width: 590px;
            margin-bottom: 32px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .hero-note {
            margin-top: 24px;
            font-size: 13px;
            color: var(--muted);
        }

        /* Hero visual */

        .hero-visual {
            display: flex;
            justify-content: center;
        }

        .hero-card {
            position: relative;

            width: 390px;
            min-height: 390px;

            padding: 35px;

            background: rgba(255, 255, 255, 0.74);
            border: 1px solid rgba(216, 117, 59, 0.18);

            border-radius: 28px;
            box-shadow: var(--shadow);

            overflow: hidden;
        }

        .hero-card::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -60px;
            top: -60px;

            border-radius: 50%;

            background: rgba(216, 117, 59, 0.12);
        }

        .hero-logo {
            width: 115px;
            height: 115px;

            margin: 10px auto 25px;

            object-fit: contain;
        }

        .hero-card h3 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .hero-card p {
            text-align: center;
            font-size: 14px;
            margin: 0 auto 25px;
        }

        .mini-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .mini-card {
            padding: 16px;

            border-radius: 14px;

            background: var(--cream);
            border: 1px solid var(--border);

            text-align: center;
        }

        .mini-card strong {
            display: block;
            margin-bottom: 4px;
            color: var(--orange);
            font-size: 14px;
        }

        .mini-card span {
            font-size: 12px;
            color: var(--muted);
        }

        /* =========================================================
           COMMON SECTION
        ========================================================= */

        .section {
            padding: 90px 28px;
        }

        .section.alt {
            background: var(--beige);
        }

        .section-container {
            max-width: 1200px;
            margin: auto;
        }

        .section-heading {
            max-width: 680px;
            margin: 0 auto 48px;
            text-align: center;
        }

        .section-heading .label {
            color: var(--orange);
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .section-heading h2 {
            font-size: 38px;
            line-height: 1.15;
            margin-bottom: 14px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 16px;
        }

        /* =========================================================
           ABOUT
        ========================================================= */

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 35px;
            align-items: stretch;
        }

        .about-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            box-shadow: var(--shadow);
        }

        .about-card h3 {
            font-size: 25px;
            margin-bottom: 14px;
        }

        .about-card p {
            color: var(--muted);
            margin-bottom: 15px;
        }

        .about-highlight {
            background: var(--orange);
            color: var(--white);
        }

        .about-highlight p {
            color: rgba(255, 255, 255, 0.9);
        }

        .about-highlight .small-label {
            color: rgba(255, 255, 255, 0.75);
        }

        .small-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            color: var(--orange);
            margin-bottom: 10px;
        }

        /* =========================================================
           FEATURES
        ========================================================= */

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;

            transition: 0.25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .feature-icon {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background: rgba(216, 117, 59, 0.12);
            color: var(--orange);

            font-size: 20px;
            font-weight: 800;

            margin-bottom: 18px;
        }

        .feature-card h3 {
            margin-bottom: 9px;
            font-size: 20px;
        }

        .feature-card p {
            color: var(--muted);
            font-size: 14px;
        }

        /* =========================================================
           HOW IT WORKS
        ========================================================= */

        .steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .step {
            position: relative;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);

            padding: 28px;
        }

        .step-number {
            font-size: 14px;
            font-weight: 800;

            width: 36px;
            height: 36px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--orange);
            color: var(--white);

            margin-bottom: 18px;
        }

        .step h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .step p {
            font-size: 14px;
            color: var(--muted);
        }

        /* =========================================================
           VOLUNTEER PREVIEW
        ========================================================= */

        .volunteer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .volunteer-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 25px;
        }

        .avatar {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: var(--soft-orange);
            color: var(--brown);

            font-weight: 800;
            font-size: 18px;

            margin-bottom: 18px;
        }

        .volunteer-card h3 {
            margin-bottom: 5px;
        }

        .volunteer-role {
            color: var(--orange);
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .volunteer-card p {
            color: var(--muted);
            font-size: 14px;
        }

        /* =========================================================
           ROADMAP
        ========================================================= */

        .roadmap-box {
            display: grid;
            grid-template-columns: 1fr 0.8fr;
            gap: 35px;

            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 24px;

            padding: 40px;

            box-shadow: var(--shadow);
        }

        .roadmap-box h2 {
            font-size: 34px;
            margin-bottom: 15px;
        }

        .roadmap-box p {
            color: var(--muted);
            margin-bottom: 25px;
        }

        .roadmap-list {
            display: grid;
            gap: 11px;
        }

        .roadmap-item {
            padding: 13px 15px;

            background: var(--cream);
            border: 1px solid var(--border);

            border-radius: 10px;

            font-size: 14px;
            color: var(--text);
        }

        .roadmap-visual {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .roadmap-circle {
            width: 230px;
            height: 230px;

            border-radius: 50%;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            background: var(--beige);
            border: 2px dashed var(--orange);

            text-align: center;
        }

        .roadmap-circle strong {
            font-size: 32px;
            color: var(--orange);
        }

        .roadmap-circle span {
            color: var(--muted);
            font-size: 13px;
            max-width: 140px;
        }

        /* =========================================================
           EXPERIENCES
        ========================================================= */

        .experience-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .experience-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 27px;
        }

        .quote-mark {
            font-size: 42px;
            line-height: 1;
            color: var(--orange);
            margin-bottom: 10px;
        }

        .experience-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 18px;
        }

        .experience-card strong {
            font-size: 14px;
        }

        /* =========================================================
           CTA
        ========================================================= */

        .cta {
            padding: 80px 28px;
        }

        .cta-box {
            max-width: 1050px;
            margin: auto;

            padding: 55px 45px;

            border-radius: 25px;

            background: var(--orange);
            color: var(--white);

            text-align: center;
            box-shadow: var(--shadow);
        }

        .cta-box h2 {
            font-size: 38px;
            margin-bottom: 12px;
        }

        .cta-box p {
            max-width: 680px;
            margin: 0 auto 25px;
            color: rgba(255,255,255,0.9);
        }

        .cta-box .btn {
            background: var(--white);
            color: var(--dark-orange);
            border: none;
        }

        .cta-box .btn:hover {
            background: var(--cream);
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        footer {
            background: #3e2b21;
            color: var(--white);
            padding: 40px 28px 25px;
        }

        .footer-container {
            max-width: 1200px;
            margin: auto;
        }

        .footer-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            padding-bottom: 25px;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }

        .footer-logo {
            width: 48px;
            height: 48px;

            object-fit: contain;

            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 5px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.78);
            font-size: 13px;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .footer-bottom {
            padding-top: 20px;

            display: flex;
            justify-content: space-between;
            gap: 15px;

            color: rgba(255,255,255,0.55);
            font-size: 12px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 950px) {

            .nav-links {
                gap: 18px;
            }

            .hero-container,
            .roadmap-box {
                grid-template-columns: 1fr;
            }

            .hero-content {
                text-align: center;
                margin: auto;
            }

            .hero-content p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .features-grid,
            .volunteer-grid,
            .experience-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 700px) {

            .nav-container {
                padding: 0 18px;
            }

            .nav-links {
                display: none;
            }

            .nav-actions .btn-outline {
                display: none;
            }

            .hero {
                min-height: auto;
            }

            .hero-container {
                padding: 65px 20px;
            }

            .hero-card {
                width: 100%;
                max-width: 390px;
            }

            .features-grid,
            .volunteer-grid,
            .experience-grid,
            .steps {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 70px 20px;
            }

            .section-heading h2 {
                font-size: 30px;
            }

            .cta {
                padding: 60px 20px;
            }

            .cta-box {
                padding: 40px 25px;
            }

            .cta-box h2 {
                font-size: 30px;
            }

            .footer-top,
            .footer-bottom {
                flex-direction: column;
            }

            .footer-links {
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<!-- =========================================================
     NAVBAR
========================================================= -->

<header class="navbar">
    <div class="nav-container">

        <!-- Project Logo -->
        <a href="#home" class="logo-link" aria-label="IGNITRA Home">
            <img src="assets/images/ingitra.png" alt="IGNITRA Logo">
        </a>

        <nav class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#features">Guidance</a>
            <a href="#volunteers">Volunteers</a>
            <a href="#roadmaps">Roadmaps</a>
            <a href="#experiences">Experiences</a>
            <a href="support.php">Support</a>
        </nav>

        <div class="nav-actions">
            <a href="pages/student/student_login.php" class="btn btn-outline">
                Login
            </a>

            <a href="pages/student/student_register.php" class="btn btn-primary">
                Register
            </a>
        </div>

    </div>
</header>


<!-- =========================================================
     HERO
========================================================= -->

<section class="hero" id="home">

    <div class="hero-container">

        <div class="hero-content">

            <span class="eyebrow">
                Student Guidance & Volunteer Community
            </span>

            <h1>
                Find the right
                <span>guidance.</span><br>
                Build your path.
            </h1>

            <p>
                IGNITRA connects students with verified volunteers,
                practical experiences, communities and structured
                resources to help them make better educational and
                career decisions.
            </p>

            <div class="hero-buttons">

                <a href="pages/student/student_register.php"
                   class="btn btn-primary">
                    Get Started
                </a>

                <a href="#features"
                   class="btn btn-outline">
                    Explore IGNITRA
                </a>

            </div>

            <div class="hero-note">
                Guidance from people with relevant experience, supported
                by structured resources.
            </div>

        </div>


        <div class="hero-visual">

            <div class="hero-card">

                <img src="assets/images/ingitra.png"
                     alt="IGNITRA"
                     class="hero-logo">

                <h3>
                    Learn. Connect. Grow.
                </h3>

                <p>
                    A structured space for students and volunteers
                    to exchange useful guidance and experience.
                </p>

                <div class="mini-grid">

                    <div class="mini-card">
                        <strong>Volunteers</strong>
                        <span>Verified guidance</span>
                    </div>

                    <div class="mini-card">
                        <strong>Roadmaps</strong>
                        <span>Structured pathways</span>
                    </div>

                    <div class="mini-card">
                        <strong>Communities</strong>
                        <span>Relevant discussions</span>
                    </div>

                    <div class="mini-card">
                        <strong>Support</strong>
                        <span>Feedback & complaints</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     ABOUT
========================================================= -->

<section class="section" id="about">

    <div class="section-container">

        <div class="section-heading">

            <div class="label">About IGNITRA</div>

            <h2>
                Guidance should be accessible,
                relevant and organized.
            </h2>

            <p>
                IGNITRA brings students, experienced volunteers and
                structured guidance resources together in one platform.
            </p>

        </div>

        <div class="about-grid">

            <div class="about-card">

                <div class="small-label">
                    The problem
                </div>

                <h3>
                    Finding the right guidance can be difficult.
                </h3>

                <p>
                    Students often depend on scattered information,
                    informal advice and multiple sources when making
                    academic or career decisions.
                </p>

                <p>
                    It can also be difficult to identify someone with
                    relevant experience and expertise.
                </p>

            </div>


            <div class="about-card about-highlight">

                <div class="small-label">
                    The IGNITRA approach
                </div>

                <h3>
                    Connect experience with students.
                </h3>

                <p>
                    IGNITRA provides verified volunteers, communities,
                    official roadmaps, guidance content and question-based
                    interactions within one structured platform.
                </p>

                <p>
                    The platform also provides administrative management
                    for volunteers, content, feedback and complaints.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     FEATURES
========================================================= -->

<section class="section alt" id="features">

    <div class="section-container">

        <div class="section-heading">

            <div class="label">What IGNITRA Provides</div>

            <h2>
                One platform for meaningful guidance.
            </h2>

            <p>
                Students can discover resources, connect with relevant
                volunteers and seek guidance according to their needs.
            </p>

        </div>


        <div class="features-grid">

            <div class="feature-card">

                <div class="feature-icon">V</div>

                <h3>Verified Volunteers</h3>

                <p>
                    Discover volunteers based on their expertise,
                    experience and guidance areas.
                </p>

            </div>


            <div class="feature-card">

                <div class="feature-icon">C</div>

                <h3>Communities</h3>

                <p>
                    Explore relevant communities created around
                    educational, career and experience-based topics.
                </p>

            </div>


            <div class="feature-card">

                <div class="feature-icon">R</div>

                <h3>Roadmaps</h3>

                <p>
                    Access structured official roadmaps to understand
                    possible academic and career pathways.
                </p>

            </div>


            <div class="feature-card">

                <div class="feature-icon">Q</div>

                <h3>Questions & Answers</h3>

                <p>
                    Students can ask guidance-related questions and
                    receive relevant answers from volunteers.
                </p>

            </div>


            <div class="feature-card">

                <div class="feature-icon">G</div>

                <h3>Guidance Content</h3>

                <p>
                    Volunteers can share relevant documents, videos
                    and experience-based guidance.
                </p>

            </div>


            <div class="feature-card">

                <div class="feature-icon">S</div>

                <h3>Student Support</h3>

                <p>
                    Students and volunteers can submit feedback and
                    private complaints directly to the administrator.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     HOW IT WORKS
========================================================= -->

<section class="section" id="how-it-works">

    <div class="section-container">

        <div class="section-heading">

            <div class="label">How It Works</div>

            <h2>
                From registration to guidance.
            </h2>

            <p>
                IGNITRA separates access according to the role of
                each participant.
            </p>

        </div>


        <div class="steps">

            <div class="step">

                <div class="step-number">01</div>

                <h3>Register</h3>

                <p>
                    Join IGNITRA as a student or apply to become a
                    volunteer.
                </p>

            </div>


            <div class="step">

                <div class="step-number">02</div>

                <h3>Get Access</h3>

                <p>
                    Students receive student access, while volunteer
                    applications are reviewed by the administrator.
                </p>

            </div>


            <div class="step">

                <div class="step-number">03</div>

                <h3>Connect & Explore</h3>

                <p>
                    Explore volunteers, communities, roadmaps and
                    useful guidance content.
                </p>

            </div>


            <div class="step">

                <div class="step-number">04</div>

                <h3>Ask & Grow</h3>

                <p>
                    Ask questions, receive guidance, share experiences
                    and provide feedback.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     VOLUNTEERS
========================================================= -->

<section class="section alt" id="volunteers">

    <div class="section-container">

        <div class="section-heading">

            <div class="label">Volunteer Community</div>

            <h2>
                Guidance from relevant experience.
            </h2>

            <p>
                IGNITRA connects students with volunteers according
                to their expertise and guidance areas.
            </p>

        </div>


        <div class="volunteer-grid">

            <div class="volunteer-card">

                <div class="avatar">A</div>

                <h3>Academic Guidance</h3>

                <div class="volunteer-role">
                    Education & Academic Planning
                </div>

                <p>
                    Guidance related to academic choices,
                    educational pathways and preparation.
                </p>

            </div>


            <div class="volunteer-card">

                <div class="avatar">C</div>

                <h3>Career Guidance</h3>

                <div class="volunteer-role">
                    Career & Skill Development
                </div>

                <p>
                    Practical guidance related to career choices,
                    skills and professional growth.
                </p>

            </div>


            <div class="volunteer-card">

                <div class="avatar">E</div>

                <h3>Practical Experience</h3>

                <div class="volunteer-role">
                    Experience & Industry Insights
                </div>

                <p>
                    Experience-based guidance to help students
                    understand real-world pathways.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     ROADMAPS
========================================================= -->

<section class="section" id="roadmaps">

    <div class="section-container">

        <div class="roadmap-box">

            <div>

                <div class="small-label">
                    Official Guidance Resources
                </div>

                <h2>
                    Understand your path before you choose it.
                </h2>

                <p>
                    IGNITRA provides official roadmap resources that
                    help students understand academic and career
                    pathways in a structured manner.
                </p>

                <div class="roadmap-list">

                    <div class="roadmap-item">
                        Academic pathway exploration
                    </div>

                    <div class="roadmap-item">
                        Course and skill preparation
                    </div>

                    <div class="roadmap-item">
                        Career-oriented guidance
                    </div>

                    <div class="roadmap-item">
                        Step-by-step pathway resources
                    </div>

                </div>

                <br>

                <a href="pages/student/student_login.php"
                   class="btn btn-primary">
                    Login to Access Roadmaps
                </a>

            </div>


            <div class="roadmap-visual">

                <div class="roadmap-circle">

                    <strong>Roadmap</strong>

                    <span>
                        Structured guidance for better decisions
                    </span>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     EXPERIENCES
========================================================= -->

<section class="section alt" id="experiences">

    <div class="section-container">

        <div class="section-heading">

            <div class="label">Experiences</div>

            <h2>
                Real experiences can make guidance practical.
            </h2>

            <p>
                Volunteers can share relevant experiences that may
                help students understand different pathways.
            </p>

        </div>


        <div class="experience-grid">

            <div class="experience-card">

                <div class="quote-mark">“</div>

                <p>
                    Experience-based guidance can help students
                    understand what a particular educational path
                    actually looks like.
                </p>

                <strong>
                    Volunteer Experience
                </strong>

            </div>


            <div class="experience-card">

                <div class="quote-mark">“</div>

                <p>
                    Relevant stories and practical lessons can make
                    career decisions easier to understand.
                </p>

                <strong>
                    Volunteer Experience
                </strong>

            </div>


            <div class="experience-card">

                <div class="quote-mark">“</div>

                <p>
                    The right guidance at the right stage can help
                    students plan their next step with more clarity.
                </p>

                <strong>
                    Student Perspective
                </strong>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     CTA
========================================================= -->

<section class="cta">

    <div class="cta-box">

        <h2>
            Start your journey with IGNITRA.
        </h2>

        <p>
            Explore guidance, connect with relevant volunteers,
            discover roadmaps and become part of a supportive
            learning community.
        </p>

        <a href="pages/student/student_register.php"
           class="btn">
            Create Student Account
        </a>

    </div>

</section>


<!-- =========================================================
     FOOTER
========================================================= -->

<footer>

    <div class="footer-container">

        <div class="footer-top">

            <img src="assets/images/ingitra.png"
                 alt="IGNITRA"
                 class="footer-logo">

            <div class="footer-links">

                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#features">Guidance</a>
                <a href="#volunteers">Volunteers</a>
                <a href="#roadmaps">Roadmaps</a>
                <a href="#experiences">Experiences</a>
                <a href="support.php">Support</a>

            </div>

        </div>


        <div class="footer-bottom">

            <span>
                © <?php echo date("Y"); ?> IGNITRA. All rights reserved.
            </span>

            <span>
                Student Guidance & Volunteer Community Platform
            </span>

        </div>

    </div>

</footer>

</body>
</html>