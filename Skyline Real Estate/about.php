<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['user_name'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Skyline Estates</title>
    <link rel="icon" type="image/x-icon" href="images/Title.png">
    <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9fafc;
            color: #333;
        }

        .header {
            background: #fff;
            border-bottom: 2px solid #f0f0f0;
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem;
        }

        .logo {
            margin-left: -120px;
            display: flex;
            align-items: center;
            font-size: 2rem;
            color: #002446;
            font-family: 'Blanka', sans-serif;
        }

        .lg {
            height: 80px;
            width: 150px;
            margin-right: 10px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-right: -120px;
            }

        .nav-links a {
            color: #002446;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #17457a;
        }

        .auth-links {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-left: 1.5rem;
        }

      

        .btn {
        padding: 0.5rem 1.2rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
        display: inline-block;

        }

        .btn-outline {
        border: 2px solid #002446;
        color: #002446;
        background: #fff;
        }

        .btn-outline:hover {
        background: #002446;
        color: #fff !important;
        }

        .btn-primary {
        background: #002446;
        color: #fff !important;
        text-decoration: none;
        }

        .btn-primary:hover {
        background: #17457a;
        color: #fff !important;
        }
            .container {
            max-width: 1100px;
            margin: 120px auto 50px;
            padding: 0 1.5rem;
        }

        h1, h2, h3 {
            color: #002446;
        }

        .about-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .about-section h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .about-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 800px;
            margin: auto;
        }

        .mission-values {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 50px;
        }

        .card {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .team {
            text-align: center;
        }

        .team h2 {
            margin-bottom: 2rem;
        }

        .team-members {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .member-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .member-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }

           
        .footer {
            background: #002446;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="nav-container">
            <div class="logo"><img src="images/logo.png" alt="logo" class="lg">Skyline Estates</div>
            <div class="nav-links">
                <a href="homepage.php">Home</a>
                <a href="properties.php">Properties</a>
                <a href="about.php">About</a>
                <a href="homepage.php#whyus">Why Choose Us</a>
                <a href="homepage.php#contact">Contact</a>
                <div class="auth-links">
                    <?php if ($is_logged_in): ?>
                        <a href="properties.php" class="btn btn-outline">See Properties</a>
                        <a href="logout.php" class="btn btn-primary">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline">Login</a>
                        <a href="register.php" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <!-- About Section -->
        <section class="about-section">
            <h1>About Skyline Estates</h1>
            <p>Skyline Estates has been a trusted name in real estate, helping clients find their dream homes and investment properties with ease and confidence. Our mission is to provide a seamless experience with verified listings, affordable deals, and expert guidance.</p>
        </section>

        <!-- Mission & Values -->
        <section class="mission-values">
            <div class="card">
                <h2>Our Mission</h2>
                <p>To simplify property buying and selling by offering verified listings, trustworthy services, and a client-first approach.</p>
            </div>
            <div class="card">
                <h2>Our Vision</h2>
                <p>To be the most reliable real estate platform, connecting buyers and sellers with transparency and efficiency.</p>
            </div>
            <div class="card">
                <h2>Our Values</h2>
                <p>Integrity, Excellence, Customer-Centric Service, Innovation, and Community Trust.</p>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="member-card">
                    <img src="images/team1.jpg" alt="Team Member">
                    <h3>Ismail Gheewala</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="member-card">
                    <img src="images/team2.jpg" alt="Team Member">
                    <h3>Kaif Patel</h3>
                    <p>Head of Operations</p>
                </div>
            </div>
        </section>

        <!-- Support Us Section -->
         


    </div>

    <footer class="footer">
        <p>&copy; 2025 Skyline Estates. All rights reserved.</p>
    </footer>
</body>

</html>
