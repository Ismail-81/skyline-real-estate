<?php
include 'config.php';
session_start();

// user session
$is_logged_in = isset($_SESSION['user_id']);
$user_name    = $is_logged_in ? $_SESSION['user_name'] : '';

// pagination
$limit    = isset($_GET['limit']) ? (int)$_GET['limit'] : 6;

// category filter
$category = $_GET['category'] ?? '';
if ($category) {
  $category_esc = mysqli_real_escape_string($conn, $category);
  $query        = "SELECT * FROM properties WHERE category='$category_esc' LIMIT $limit";
  $total_result = mysqli_query($conn, "SELECT * FROM properties WHERE category='$category_esc'");
} else {
  $query        = "SELECT * FROM properties LIMIT $limit";
  $total_result = mysqli_query($conn, "SELECT * FROM properties");
}
$result = mysqli_query($conn, $query);
$total  = mysqli_num_rows($total_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Properties | Skyline Estates</title>
  <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/Title.png">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: #fff;
      color: #333;
      line-height: 1.6;
    }

    /* Header */
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
      /* font-weight: bold; */
      color: #002446;
      /* font-family: "Asimovian", sans-serif; */
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

    

    .btn-large {
      padding: 0.9rem 2rem;
      font-size: 1.1rem;
      border-radius: 8px;
    }


    .hero {
      background: url('https://plus.unsplash.com/premium_photo-1663089512281-ef61fee86c46?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #fff;
      position: relative;
      margin-top: 80px;
    }

    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 36, 70, 0.6);
    }

    .hero-content {
      position: relative;
      z-index: 1;
      max-width: 700px;
      padding: 0 20px;
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
      font-weight: 700;
    }

    .hero p {
      font-size: 1.1rem;
      margin-bottom: 20px;
    }

    /* Properties */
    .properties {
      max-width: 1200px;
      margin: 3rem auto;
      padding: 4rem 1.5rem 1rem 1.5rem;

    }

    .properties h2 {
      text-align: center;
      color: #002446;
      margin-bottom: 2rem;
      font-size: 2.2rem;
    }

    /* dropdown */
    form.category-filter {
      text-align: center;
      margin: -10px 0 40px 0;
    }

    form.category-filter select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background: #fff url("data:image/svg+xml;utf8,<svg fill='%23002446' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>") no-repeat right 0.8rem center;
      background-size: 16px;
      border: 2px solid #002446;
      border-radius: 6px;
      padding: 0.6rem 2.2rem 0.6rem 0.8rem;
      font-size: 1rem;
      color: #002446;
      cursor: pointer;
      transition: 0.3s;

    }

    form.category-filter select:hover {
      border-color: #17457a;
    }

    form.category-filter select:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(0, 36, 70, 0.2);
    }

    .property-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .property-card {
      background: #fff;
      border-radius: 4px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
      transition: 0.3s;
    }

    .property-card:hover {
      transform: translateY(-5px);
    }

    .property-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .property-card .info {
      padding: 1rem;
    }

    .property-card h3 {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
      color: #002446;
    }

    .property-card p {
      color: #555;
      font-size: 0.95rem;
    }

    /* Footer */
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
  <!-- Header -->
  <header class="header">
    <nav class="nav-container">
      <div class="logo"><img src="images/logo.png" alt="logo" class="lg">Skyline Estates</div>
      <div class="nav-links">
        <a href="homepage.php">Home</a>
        <a href="#properties">Properties</a>
        <a href="about.php">About</a>
        <a href="homepage.php#whyus">Why Choose Us</a>
        <a href="homepage.php#contact">Contact</a>
        <div class="auth-links">
          <?php if ($is_logged_in): ?>
            <a href="addProperty.php" class="btn btn-outline">+ Sell Property</a>
            <a href="logout.php" class="btn btn-primary">Logout</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-outline">Login</a>
            <a href="register.php" class="btn btn-primary">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>


    <section class="hero">
    <div class="hero-content">
      <h1>Find Your Dream Property</h1>
      <p>Browse through houses, villas, apartments and lands — handpicked for you.</p>
      <a href="#properties" class="btn btn-primary">Browse Properties</a>
    </div>
  </section>

  <!-- Properties -->
  <section id="properties" class="properties">
    <h2>Available Properties</h2>

    <!-- 🔹 Category filter -->
    <form method="get" class="category-filter">
      <select name="category" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <option value="House" <?= ($category == 'House') ? 'selected' : ''; ?>>House</option>
        <option value="Villa" <?= ($category == 'Villa') ? 'selected' : ''; ?>>Villa</option>
        <option value="Apartment" <?= ($category == 'Apartment') ? 'selected' : ''; ?>>Apartment</option>
        <option value="Land" <?= ($category == 'Land') ? 'selected' : ''; ?>>Land</option>
      </select>
      <input type="hidden" name="limit" value="<?= $limit ?>">
      <noscript><button type="submit">Go</button></noscript>
    </form>

    <div class="property-grid">
      <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="property-card">
            <img src="<?= htmlspecialchars($row['image_path']); ?>" alt="Property">
            <div class="info">
              <h3><?= htmlspecialchars($row['title']); ?></h3>
              <p>₹<?= number_format($row['price']); ?> • <?= htmlspecialchars($row['location']); ?></p>
              <a href="property.php?id=<?= $row['id']; ?>" class="btn btn-primary" style="margin-top:10px; display:inline-block;">
                View Details
              </a>
            </div>
          </div>
        <?php } ?>
      <?php else: ?>
        <p>No properties found.</p>
      <?php endif; ?>
    </div>

    <?php if ($limit < $total): ?>
      <div style="text-align:center; margin-top:60px;">
        <a href="?category=<?= urlencode($category) ?>&limit=<?= $limit + 6; ?>" class="btn btn-outline">
          Load More
        </a>
      </div>
    <?php endif; ?>
  </section>

  <!-- Footer -->
  <footer class="footer" id="contact">
    <p>&copy; 2025 Skyline Estates. All rights reserved.</p>
  </footer>
</body>

</html>