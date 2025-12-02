<?php
session_start();
include 'config.php';

// Check for property ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid property request.");
}

$property_id = intval($_GET['id']);
$is_logged_in = isset($_SESSION['user_id']);

// Fetch property details
$query = "SELECT * FROM properties WHERE id = $property_id LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Property not found.");
}

$property = mysqli_fetch_assoc($result);
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$is_logged_in) {
        $message = "<p style='color:red;'>You must be logged in to request a purchase.</p>";
    } else {
        $user_id = $_SESSION['user_id'];
        $name    = mysqli_real_escape_string($conn, $_POST['name']);
        $email   = mysqli_real_escape_string($conn, $_POST['email']);
        $phone   = mysqli_real_escape_string($conn, $_POST['phone']);
        $msg     = mysqli_real_escape_string($conn, $_POST['message']);

        // Insert buy request into property_requests table
        $insert = "INSERT INTO property_requests 
                   (property_id, user_id, request_type, status, message, created_at)
                   VALUES ($property_id, $user_id, 'buy', 'pending', '$msg', NOW())";

        if (mysqli_query($conn, $insert)) {
            $message = "<p style='color:green; font-weight:bold;'>Your buy request has been sent to the admin for approval.</p>";
        } else {
            $message = "<p style='color:red;'>Error: Could not submit request. " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy <?php echo htmlspecialchars($property['title']); ?> | Skyline Estates</title>
    <link rel="icon" type="image/x-icon" href="images/Title.png">
    <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafc;
            margin: 0;
            padding: 0;
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
        font-style: normal;
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

        .container {
            max-width: 700px;
            margin: 150px auto 70px auto;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #002446;
        }

        .property-info {
            margin: 20px 0;
            padding: 1rem;
            background: #f3f6fa;
            border-radius: 8px;
        }

        .price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #17457a;
            margin: 10px 0;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 600;
        }

        input,
        textarea {
            width: 97%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
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

        .btn-primary {
            background: #002446;
            color: #fff !important;
        }

        .btn-primary:hover {
            background: #17457a;
            color: #fff !important;
        }

        .footer {
            background: #002446;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            margin-top: 50px;
        }

        .message {
            margin-bottom: 15px;
            text-align: center;
            font-weight: bold;
        }

        .back-link {
            text-align: center;
            margin-bottom: 15px;
        }

        .back-link a {
            text-decoration: none;
            color: #002446;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
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
                        <a href="logout.php" class="btn btn-primary" style="padding:10px 15px;">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary" style="padding:10px 15px;">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="back-link"><a href="properties.php">← Back to Properties</a></div>
        <h1>Buy Property</h1>

        <div class="property-info">
            <h2><?php echo htmlspecialchars($property['title']); ?></h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
            <p><strong>Price:</strong> ₹<?php echo number_format($property['price']); ?></p>
        </div>

        <div class="message"><?php echo $message; ?></div>

        <form method="POST" action="">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <label>Message</label>
            <textarea name="message" rows="4">I am interested in buying this property.</textarea>

            <button type="submit" class="btn btn-primary">Send Buy Request</button>
        </form>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Skyline Estates. All rights reserved.</p>
    </footer>
</body>

</html>