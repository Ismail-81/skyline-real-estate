<?php
session_start();
include "config.php";

// Only admin can access
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Get property id
$id = $_GET['id'] ?? null;
if (!$id) {
    die("No property ID given.");
}

// Fetch property
$result = mysqli_query($conn, "SELECT * FROM properties WHERE id=$id");
$property = mysqli_fetch_assoc($result);
if (!$property) {
    die("Property not found.");
}

// Update property
$message = "";
if (isset($_POST['update'])) {
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price       = (float)$_POST['price'];
    $sqrft       = (int)$_POST['sqrft'];
    $type        = mysqli_real_escape_string($conn, $_POST['type']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $address     = mysqli_real_escape_string($conn, $_POST['address']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle file upload
    $image_path = $property['image_path']; // keep old image if no new file uploaded
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        
        $filename = time() . "_" . basename($_FILES['image_file']['name']);
        $target_file = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        } else {
            $message = "Error uploading image.";
        }
    }

    $query = "UPDATE properties 
              SET title='$title', description='$description', price=$price, sqrft=$sqrft, type='$type', 
                  location='$location', address='$address', image_path='$image_path', category='$category'
              WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        $message = "Property updated successfully!";
        $message_type = "success";
    } else {
        $message = "Error updating property: " . mysqli_error($conn);
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Property | Skyline Estates</title>
<link rel="icon" type="image/x-icon" href="images/Title.png">
<link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
<style>
    body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f7fa;
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
            max-width: 600px;
            margin: 120px auto 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #002446;
            margin-bottom: 20px;
        }

        form label {
            display: block;
            margin: 12px 0 6px;
            font-weight: 600;
        }

        form input,
        form textarea,
        form select {
            width: 97%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            margin-bottom: 15px;
        }
        form select {
            width: 100%;
        }

        form input[type="number"] {
            min: 0;
        }

        form textarea {
            resize: vertical;
            height: 100px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-primary {
            background: #002446;
            color: #fff !important;
        }

        .btn-primary:hover {
            background: #17457a;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #002446;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
          .footer {
            background: #002446;
            color: #fff;
            text-align: center;
            padding: 1.2rem;
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
                    <a href="logout.php" class="btn btn-primary" style="padding: 10.5px 15px;">Logout</a>
                </div>
            </div>
        </nav>
    </header>

<div class="container">
    <h2>Edit Property</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?= $message_type ?? ''; ?>"><?= $message; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Property Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($property['title']); ?>" required>

        <label>Description</label>
        <textarea name="description" required><?= htmlspecialchars($property['description']); ?></textarea>

        <label>Price (₹)</label>
        <input type="number" name="price" value="<?= $property['price']; ?>" required>

        <label>Total Area (sq.ft)</label>
        <input type="number" name="sqrft" value="<?= $property['sqrft']; ?>" required>

        <label>Property Type</label>
        <select name="type" required>
            <option value="Buy" <?= $property['type'] == 'Buy' ? 'selected' : ''; ?>>Buy</option>
            <option value="Rent" <?= $property['type'] == 'Rent' ? 'selected' : ''; ?>>Rent</option>
        </select>

        <label>Location</label>
        <input type="text" name="location" value="<?= htmlspecialchars($property['location']); ?>" required>

        <label>Full Address</label>
        <textarea name="address" required><?= htmlspecialchars($property['address']); ?></textarea>

        <label>Current Image</label>
        <img src="<?= htmlspecialchars($property['image_path']); ?>" style="width:150px; display:block; margin-bottom:10px;">

        <label>Change Image</label>
        <input type="file" name="image_file" accept="image/*">

        <label>Category</label>
        <select name="category" required>
            <option value="House" <?= $property['category'] == 'House' ? 'selected' : ''; ?>>House</option>
            <option value="Villa" <?= $property['category'] == 'Villa' ? 'selected' : ''; ?>>Villa</option>
            <option value="Apartment" <?= $property['category'] == 'Apartment' ? 'selected' : ''; ?>>Apartment</option>
            <option value="Land" <?= $property['category'] == 'Land' ? 'selected' : ''; ?>>Land</option>
        </select>

        <button type="submit" name="update" class="btn btn-primary">Update Property</button>
    </form>

    <a href="admin.php" class="back-link">← Back to Admin</a>
</div>
            <footer class="footer" id="contact">
                <p>&copy; 2025 Skyline Estates. All rights reserved.</p>
            </footer>
</body>
</html>
