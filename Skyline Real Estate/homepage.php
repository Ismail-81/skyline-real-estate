<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$user_name    = $is_logged_in ? $_SESSION['user_name'] : '';

include 'config.php';
// include 'auth.php';
// 🔹 get category from GET
$category = $_GET['category'] ?? '';
if ($category) {
    $category = mysqli_real_escape_string($conn, $category);
    $query = "SELECT * FROM properties WHERE category='$category' ORDER BY id DESC LIMIT 3";
} else {
    $query = "SELECT * FROM properties ORDER BY id DESC LIMIT 3";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Skyline Estates </title>
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


    .hero {
      margin-top: 80px;
      text-align: center;
      padding: 100px 1.5rem;
      background-image: url("images/Background.jpg");
      background-size: cover;
      background-position: center;
      /* background: linear-gradient(135deg, #002446, #17457a); */
      color: #fff;
    }

    .welcome-text {
      font-size: 1.7rem;
    }

    .hero h1 {
      font-size: 2.8rem;
      margin-bottom: 1rem;
      color: #fff;
      font-weight: 700;
    }

    .hero p {
      margin-bottom: 2rem;
      font-size: 1.2rem;
      opacity: 0.9;
      font-weight: bold;
    }

    .hero-div {
      /* background-color: rgba(255, 255, 255, 0.4); */
      padding: 45px 60px;
      width: fit-content;
      margin-left: auto;
      margin-right: auto;
      background: rgba(0, 0, 0, 0.28);
      /* background: rgba(255, 255, 255, 0.13); */
      border-radius: 16px;
      box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(2px);
      /*-webkit-backdrop-filter: blur(3.8px);*/
      border: 1px solid rgba(255, 255, 255, 0.64);
    }

    .hero-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-large {
      padding: 0.9rem 2rem;
      font-size: 1.1rem;
      border-radius: 8px;
    }

    /* Dropdown styling */
    form select {
      appearance: none;           /* remove default arrow */
      -webkit-appearance: none;
      -moz-appearance: none;
      background: #fff url("data:image/svg+xml;utf8,<svg fill='%2317457a' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>") no-repeat right 0.8rem center;
      background-size: 16px;
      border: 2px solid #17457a;
      border-radius: 6px;
      padding: 0.6rem 3.2rem 0.6rem 1.8rem;
      font-size: 1.2rem;
      color: #17457a;
      cursor: pointer;
      transition: 0.3s;
      margin-bottom: 2rem;
    }

    form select:hover {
      border-color: #0b2e59;
    }

    form select:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(23, 69, 122, 0.3);
    }


    .properties {
      padding: 40px 1.5rem;
      background: #f9fafc;
      text-align: center;
      border-bottom: 1px solid #e0e0e0;
    }

    .properties h2 {
      font-size: 2rem;
      color: #002446;
      margin-bottom: 2rem;
    }

    .properties-grid {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .property-card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
      transition: 0.3s;
    }

    .property-card:hover {
      transform: translateY(-5px);
    }

    .property-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .property-info {
      padding: 1rem;
      text-align: left;
    }

    .property-info h3 {
      margin-bottom: 0.5rem;
      color: #002446;
      font-size: 1.2rem;
    }

    .property-info p {
      color: #555;
      font-size: 0.95rem;
    }

    .property-info .price {
      display: block;
      margin-top: 0.8rem;
      font-weight: bold;
      color: #17457a;
    }


    .features {
      padding: 50px 1.5rem;
      background: #f9fafc;
      text-align: center;
      border-bottom: 1px solid #e0e0e0;
    }

    .features h2 {
      font-size: 2.2rem;
      color: #002446;
      margin-bottom: 2.5rem;
    }

    .features-grid {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .feature-card {
      background: #fff;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
      transition: 0.3s;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-card img {
      width: 70px;
      height: 70px;
      margin-bottom: 1rem;
    }

    .feature-card h3 {
      margin-bottom: 0.8rem;
      color: #002446;
      font-size: 1.2rem;
    }

    .feature-card p {
      font-size: 0.95rem;
      color: #555;
    }



    .contact {
      padding: 60px 1.5rem;
      background: #f9fafc;
      text-align: center;
    }

    .contact h2 {
      font-size: 2.2rem;
      color: #002446;
      margin-bottom: 1rem;
    }

    .contact p {
      margin-bottom: 2rem;
      font-size: 1rem;
      color: #002446;
    }

    .contact-container {
      max-width: 1100px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
      align-items: flex-start;
    }

    .contact-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .contact-form input,
    .contact-form textarea {
      padding: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      outline: none;
    }

    .contact-form input:focus,
    .contact-form textarea:focus {
      border-color: #002446;
      box-shadow: 0 0 5px rgba(39, 100, 165, 0.2);
    }

    .contact-info {
      text-align: left;
      background: #f9fafc;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .contact-info h3 {
      margin-bottom: 1rem;
      color: #002446;
    }



    .footer {
      background: #002446;
      color: #fff;
      text-align: center;
      padding: 1.5rem;
      margin-top: 50px;
    }
  </style>

  <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/Title.png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <!-- Header -->
  <header class="header">
    <nav class="nav-container">
      <div class="logo"><img src="images/logo.png" alt="logo" class="lg">Skyline Estates</div>
      <div class="nav-links">
        <a href="#home">Home</a>
        <a href="properties.php">Properties</a>
        <a href="about.php">About</a>
        <a href="#whyus">Why Choose Us</a>
        <a href="#contact">Contact</a>
        <div class="auth-links">
          <?php if ($is_logged_in): ?>
            <a href="properties.php" class="btn btn-outline">See Properties</a>
            <a href="logout.php" class="btn btn-primary" style="padding: 10.5px 15px;">Logout</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-outline">Login</a>
            <a href="register.php" class="btn btn-primary" style="padding: 10.5px 15px;">Register</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
  </header>

  <!-- Hero -->
  <section id="home" class="hero">
    <div class="hero-div">
      <?php if ($is_logged_in): ?>
        <span class="welcome-text">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
      <?php endif ?>
      <h1>Find Your Dream Home</h1>
      <p>Discover verified properties with trust and ease.</p>
      <div class="hero-buttons">
        <?php if ($is_logged_in): ?>
          <a href="properties.php" class="btn btn-primary btn-large">See Properties</a>
        <?php else: ?>
          <a href="register.php" class="btn btn-primary btn-large">Get Started</a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Featured Properties -->
  <section id="properties" class="properties">
    <h2>Featured Properties</h2>

    <!-- 🔹 Category dropdown -->
    <form method="get" style="margin-bottom:20px;">
      <select name="category" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <option value="House"     <?= $category=='House'?'selected':''; ?>>House</option>
        <option value="Villa"     <?= $category=='Villa'?'selected':''; ?>>Villa</option>
        <option value="Apartment" <?= $category=='Apartment'?'selected':''; ?>>Apartment</option>
        <option value="Land"      <?= $category=='Land'?'selected':''; ?>>Land</option>
      </select>
      <noscript><button type="submit">Go</button></noscript>
    </form>

    <div class="properties-grid">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="property-card">
          <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
          <div class="property-info">
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['location']); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
            <span class="price">₹<?php echo number_format($row['price']); ?></span>
            <a href="property.php?id=<?php echo $row['id']; ?>"
               class="btn btn-primary"
               style="margin-top:10px; display:inline-block;">
               View Details
            </a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div style="text-align:center; margin-top:50px">
      <a href="properties.php" class="btn btn-outline">See More Properties</a>
    </div>
  </section>


  <!-- Why Choose Us -->
  <section id="whyus" class="features">
    <h2>Why Choose Us?</h2>

    <div class="features-grid">

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/home-page.png" alt="Verified">
        <h3>Verified Listings</h3>
        <p>All properties are checked and verified for maximum trust.</p>
      </div>

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/laptop.png" alt="Easy">
        <h3>Easy to Use</h3>
        <p>Simple interface for browsing and managing your properties.</p>
      </div>

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/conference-call.png" alt="Direct">
        <h3>Direct Contact</h3>
        <p>Connect directly with buyers and sellers securely.</p>
      </div>

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/price-tag.png" alt="Affordable">
        <h3>Affordable Deals</h3>
        <p>Find the best property deals at unbeatable prices.</p>
      </div>

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/headset.png" alt="24/7 Support">
        <h3>24/7 Support</h3>
        <p>Get assistance anytime with our round-the-clock support.</p>
      </div>

      <div class="feature-card">
        <img src="https://img.icons8.com/ios-filled/100/002446/shield.png" alt="Secure Transactions">
        <h3>Secure Transactions</h3>
        <p>Your data and payments are protected with top-level security.</p>
      </div>
    </div>

  </section>

  <!-- Contact Section -->

  <?php
  include 'config.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
      $query = "INSERT INTO contact_messages (name, email, message) 
              VALUES ('$name', '$email', '$message')";
      if (mysqli_query($conn, $query)) {
        echo "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'We will get back to you soon.',
                    confirmButtonColor: '#2764a5'
                }).then(() => {
                    window.location.href = 'homepage.php#contact';
                });
            </script>
            ";
      } else {
        echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again later!',
                    confirmButtonColor: '#2764a5'
                });
            </script>
            ";
      }
    } else {
      echo "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Missing Fields',
                text: 'Please fill out all fields before submitting.',
                confirmButtonColor: '#2764a5'
            });
        </script>
        ";
    }
  }

  ?>
  <section id="contact" class="contact">
    <h2>Contact Us</h2>
    <p>We’d love to hear from you! Reach out with any questions or inquiries.</p>

    <div class="contact-container">
      <form action="" method="POST" class="contact-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button type="submit" class="btn btn-primary" style="padding: 10.5px 15px;">Send Message</button>
      </form>

      <div class="contact-info">
        <h3>Get in Touch</h3>
        <p><strong>Email:</strong> support@skylineestates.com</p>
        <p><strong>Phone:</strong> +91 95747 95108, +91 7777965301</p>
        <p><strong>Address:</strong> 123 Skyline Estates Ave, Bharuch, Gujarat, India</p>
      </div>
    </div>
  </section>




  <!-- Footer -->
  <footer id="footer" class="footer">
    <p>&copy; 2025 RealEstate Pro. All rights reserved.</p>
  </footer>
</body>

</html>