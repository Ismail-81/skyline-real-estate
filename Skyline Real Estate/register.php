<?php
session_start(); // ✅ Start session to store user login
include 'config.php';

$error = "";
$success = "";

if (isset($_POST['submit'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];

  if (empty($name) || empty($email) || empty($password) || empty($phone)) {
    $error = "All fields are required!";
  } else if (strlen($password) < 6) {
    $error = "Password must be at least 6 characters!";
  } else {
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
      $error = "Email already exists! Please try again.";
    } else {

      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $insert_query = "INSERT INTO users (full_name, email, phone_number, password) 
                       VALUES ('$name', '$email', '$phone', '$hashed_password')";

      if (mysqli_query($conn, $insert_query)) {
        // ✅ Get the new user ID
        $user_id = mysqli_insert_id($conn);

        // ✅ Auto login after register
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        // ✅ Redirect to last visited restricted page if available
        if (isset($_SESSION['redirect_url'])) {
          $redirect = $_SESSION['redirect_url'];
          unset($_SESSION['redirect_url']); // clear it after use
          header("Location: $redirect");
        } else {
          header("Location: homepage.php");
        }
        exit();

      } else {
        $error = "Registration failed! Please try again.";
      }
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="images/Title.png">
  <title>Register | Skyline Estates</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* background: linear-gradient(135deg, #002446 0%, #2764a5ff 100%); */
      background-image: url('images/BackGround.jpg');
      background-size: cover;
      background-position: center;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      max-width: 450px;
      width: 100%;
      background-color: white;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
      animation: slideUp 0.6s ease-out;

    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
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
      font-family: 'Blanka', sans-serif;
      -webkit-text-fill-color: transparent;
      font-size: 1.9rem;
      margin-bottom: 6px;
      font-weight: 600;
    }

    .header p {
      color: #6c757d;
      font-size: 1rem;
      margin: 0;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .form-group {
      width: 100%;
    }

    label {
      display: block;
      margin-bottom: 6px;
      color: #495057;
      font-weight: 500;
      font-size: 0.9rem;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="tel"] {
      width: 100%;
      padding: 12px 14px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 15px;
      box-sizing: border-box;
      transition: all 0.3s ease;
      background-color: #f8f9fa;
    }

    input:focus {
      border-color: #4ca1af;
      outline: none;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(76, 161, 175, 0.1);
      transform: translateY(-1px);
    }

    .alert {
      padding: 12px 15px;
      margin-bottom: 20px;
      border-radius: 8px;
      font-weight: 500;
      border-left: 4px solid;
    }

    .alert-error {
      /* text-align: center;
      margin: 5px 0; */
      background-color: #f8d7da;
      color: #721c24;
      border-color: #dc3545;
      /* padding: 3px;
      border-radius: 2px; */
    }

    .alert-success {
      /* text-align: center;
      margin: 5px 0; */
      background-color: #e6f4ea;
      color: #155724;
      border-color: #28a745;
      /* padding: 3px;
      border-radius: 2px; */
    }

    .submit-btn {
      padding: 14px;
      background: linear-gradient(135deg, #002446 0%, #002566 100%);
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 5px;
      transition: all 0.3s ease;
      letter-spacing: 0.5px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(76, 161, 175, 0.35);
    }

    .login-link {
      text-align: center;
      margin-top: 18px;
      padding-top: 15px;
      border-top: 1px solid #e9ecef;
      color: #6c757d;
      font-size: 0.9rem;
    }

    .login-link a {
      color: #1e3c72;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .login-link a:hover {
      color: #002446;
      text-decoration: underline;
    }
  </style>
  <link href="https://fonts.cdnfonts.com/css/blanka" rel="stylesheet">
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Skyline Estates</h1>
      <p>Create your account</p>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-error">
        <?php echo $error; ?>
      </div>
    <?php endif ?>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success">
        <?php echo $success; ?>
      </div>
    <?php endif ?>

    <form method="POST" action="">
      <div class="form-group">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
      </div>

      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter password (min 6 characters)" required>
      </div>

      <button type="submit" name="submit" class="submit-btn">Create Account</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="login.php">Login here</a>
    </div>
  </div>
</body>

</html>