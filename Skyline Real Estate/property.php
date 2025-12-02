<?php
session_start();
include 'config.php'; // DB connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Property not found.");
}
$property_id = intval($_GET['id']);
$is_logged_in = isset($_SESSION['user_id']);

// Fetch property
$query = "SELECT * FROM properties WHERE id = $property_id LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    die("Property not found.");
}
$property = mysqli_fetch_assoc($result);

// Calculate price per sq.ft safely
$price_per_sqft = ($property['sqrft'] > 0) ? $property['price'] / $property['sqrft'] : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($property['title']); ?> | Skyline Estates</title>
    <link rel="icon" type="image/x-icon" href="images/Title.png">
    <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f9fafc;
            margin: 0;
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
            margin-left: -60px;
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
            max-width: 1100px;
            margin: 140px auto 40px;
            padding: 0 1.5rem;
        }

        .property-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .property-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .property-details h2 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
            color: #002446;
        }

        .property-details p {
            font-size: 1rem;
            margin: 0.5rem 0;
            color: #555;
        }

        .property-details strong {
            color: #002446;
        }

        .price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #17457a;
            margin: 1rem 0;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
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
            <div class="logo"><img src="images/logo.png" class="lg">Skyline Estates</div>
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
                        <?php $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; ?>
                        <a href="login.php" class="btn btn-outline">Login</a>
                        <a href="register.php" class="btn btn-primary">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="property-wrapper">
            <div class="property-image">
                <img src="<?php echo htmlspecialchars($property['image_path']); ?>" alt="<?php echo htmlspecialchars($property['title']); ?>">
            </div>
            <div class="property-details">
                <h2><?php echo htmlspecialchars($property['title']); ?></h2>
                
                <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
                <p><strong>Property Type:</strong> <?php echo htmlspecialchars($property['type']); ?></p>
                <p><strong>Total Area:</strong> <?php echo number_format($property['sqrft']); ?> sq.ft</p>
                <p><strong>Price per sq.ft:</strong> ₹<?php echo number_format($price_per_sqft, 2); ?></p>
                <p class="price"><strong>Total Price:</strong> ₹<?php echo number_format($property['price']); ?></p>
                <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($property['address'])); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                <?php if ($is_logged_in): ?>
                    <a href="buy.php?id=<?php echo $property['id']; ?>" class="btn btn-primary">Buy Now</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login to Buy</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 RealEstate Pro. All rights reserved.</p>
    </footer>
</body>

</html>