<?php
session_start();
include 'config.php';

// Only logged-in users can request
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = (float)$_POST['price'];
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $type        = mysqli_real_escape_string($conn, $_POST['type']);
    $sqrft       = (int)$_POST['sqrft'];
    $address     = mysqli_real_escape_string($conn, $_POST['address']);

    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_ext, $allowed_ext)) {
            $message = "<p style='color:red;'>Invalid image type. Only JPG, PNG, GIF allowed.</p>";
        } else {
            // Create uploads folder if not exists
            if (!is_dir('uploads')) mkdir('uploads', 0777, true);

            $new_file_name = uniqid('prop_') . '.' . $file_ext;
            $destination = '../PHP Project/uploads/' . $new_file_name;

            if (move_uploaded_file($file_tmp, $destination)) {
                $image_path = $destination; // Store path for DB
            } else {
                $message = "<p style='color:red;'>Failed to upload image.</p>";
            }
        }
    } else {
        $message = "<p style='color:red;'>Please select an image.</p>";
    }

    // Insert into DB if no errors
    if (empty($message)) {
        $insert = "INSERT INTO property_requests 
                   (request_type, user_id, title, description, price, location, image_path, category, type, sqrft, address, status, created_at)
                   VALUES
                   ('Add', $user_id, '$title', '$description', $price, '$location', '$image_path', '$category', '$type', $sqrft, '$address', 'pending', NOW())";

        if (mysqli_query($conn, $insert)) {
            $message = "<p style='color:green; font-weight:bold;'>Your property request has been sent to the admin for approval.</p>";
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
    <title>Request Add Property | Skyline Estates</title>
    <link rel="icon" type="image/x-icon" href="images/Title.png">
    <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
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
            margin-right: -120px;
            align-items: center;
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
            max-width: 600px;
            margin: 100px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #002446;
        }

        form label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
        }

        form input,
        form textarea,
        form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        form textarea {
            resize: vertical;
            height: 100px;
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

        .message {
            margin: 15px 0;
            text-align: center;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #002446;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
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
                    <a href="logout.php" class="btn btn-primary" style="padding:10px 15px;">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h2>Request to Add New Property</h2>
        <div class="message"><?php echo $message; ?></div>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Property Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price (₹)</label>
            <input type="number" id="price" name="price" step="1000" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>

            <label for="image">Property Image</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="">Select Category</option>
                <option value="House">House</option>
                <option value="Villa">Villa</option>
                <option value="Apartment">Apartment</option>
                <option value="Land">Land</option>
            </select>

            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="">Select Type</option>
                <option value="Buy">Buy</option>
                <option value="Rent">Rent</option>
            </select>

            <label for="sqrft">Square Footage</label>
            <input type="number" id="sqrft" name="sqrft" required>

            <label for="address">Full Address</label>
            <input type="text" id="address" name="address" required>

            <button type="submit" class="btn btn-primary">Send Property Request</button>
        </form>
        <a href="homepage.php" class="back-link">← Back to Home</a>
    </div>

</body>

</html>