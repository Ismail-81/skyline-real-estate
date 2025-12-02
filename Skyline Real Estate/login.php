<?php
session_start();
include 'config.php';

// store redirect URL if passed (e.g., login.php?redirect=/property.php?id=15)
if (!empty($_GET['redirect'])) {
    $_SESSION['redirect_url'] = $_GET['redirect'];
}

// if already logged in, go to redirect or homepage
if (isset($_SESSION['user_id'])) {
    $redirect = $_SESSION['redirect_url'] ?? 'homepage.php';
    unset($_SESSION['redirect_url']);
    header("Location: $redirect");
    exit();
}

$error = '';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $admin_user = "admin@gmail.com";
    $admin_pass = "admin123";

    // --- Admin login ---
    if ($email === $admin_user && $password === $admin_pass) {
        $_SESSION['admin'] = $email;
        header("Location: admin.php");
        exit();
    }

    // --- User login ---
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields!";
    } else {
        $login_query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $login_query);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];

                // redirect to previous page or homepage
                $redirect = $_SESSION['redirect_url'] ?? 'homepage.php';
                unset($_SESSION['redirect_url']);
                header("Location: $redirect");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Email not found!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Skyline Estates</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('images/Background.jpg');
      background-size: cover;
      background-position: center;
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      max-width: 400px;
      width: 100%;
      background-color: #fff;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(25px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      text-align: center;
      margin-bottom: 25px;
    }

    .header h1 {
      background: linear-gradient(135deg, #002446 0%, #2764a5ff 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-family: 'Blanka', sans-serif;
      font-size: 2rem;
      font-weight: 600;
      margin: 0 0 6px;
    }

    .header p {
      color: #6c757d;
      font-size: 1rem;
      margin: 0;
    }

    .back-link {
      text-align: center;
      margin-bottom: 15px;
    }

    .back-link a {
      color: #002446;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
    }

    .back-link a:hover {
      text-decoration: underline;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      color: #495057;
      font-weight: 500;
      font-size: 0.9rem;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 16px;
      background-color: #f8f9fa;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }

    input:focus {
      border-color: #002446;
      outline: none;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.15);
    }

    .submit-btn {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #002446 0%, #002566 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(42, 82, 152, 0.3);
    }

    .remember-me {
      display: flex;
      align-items: center;
      margin-top: 10px;
    }

    .remember-me input[type="checkbox"] {
      margin-right: 6px;
      transform: scale(1.1);
    }

    .remember-me label {
      margin: 0;
      color: #6c757d;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .forgot-password {
      text-align: center;
      margin: 15px 0;
    }

    .forgot-password a {
      color: #6c757d;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .forgot-password a:hover {
      color: #002446;
      text-decoration: underline;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      padding-top: 15px;
      border-top: 1px solid #e9ecef;
      color: #6c757d;
      font-size: 0.9rem;
    }

    .register-link a {
      color: #002446;
      text-decoration: none;
      font-weight: 600;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    .alert {
      padding: 12px 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: 500;
      border-left: 4px solid;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
      border-color: #dc3545;
    }

    @media (max-width: 768px) {
      body {
        padding: 10px;
      }

      .container {
        padding: 25px;
      }

      .header h1 {
        font-size: 1.7rem;
      }
    }
  </style>
  <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="images/Title.png">
</head>

<body>
  <div class="container">

    <div class="back-link">
      <a href="homepage.php">← Back to Home</a>
    </div>

    <div class="header">
      <h1>Skyline Estates</h1>
      <p>Welcome back!</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-error">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email"
          value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <div class="remember-me">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
      </div>

      <button type="submit" name="submit" class="submit-btn">Login</button>
    </form>

    <div class="forgot-password">
      <a href="#">Forgot your password?</a>
    </div>

    <div class="register-link">
      Don’t have an account? <a href="register.php">Create account</a>
    </div>
  </div>
</body>

</html>
