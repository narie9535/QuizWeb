<?php

require 'config.php'; // database connection

if (isset($_POST["submit"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password === $row["password"]) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: quize1.php");
            exit;
        } else {
            echo "<script>alert('Wrong Password!');</script>";
        }
    } else {
        echo "<script>alert('User not registered!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    /* Background */
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #ff512f, #dd2476);
    }

    /* Card */
    .container {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      width: 350px;
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    /* Inputs */
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 8px;
      border: 1px solid #ccc;
      outline: none;
      font-size: 14px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #dd2476;
      box-shadow: 0 0 8px rgba(221,36,118,0.3);
    }

    /* Button */
    button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(90deg, #ff512f, #dd2476);
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: linear-gradient(90deg, #dd2476, #ff512f);
      transform: scale(1.05);
    }

    /* Link */
    a {
      display: block;
      margin-top: 15px;
      color: #dd2476;
      text-decoration: none;
      font-size: 14px;
    }

    a:hover {
      text-decoration: underline;
    }

    /* Animation */
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Login</h2>
    <form action="" method="post" autocomplete="off">
      <input type="email" name="email" id="email" placeholder="Enter Email" required>
      <input type="password" name="password" id="password" placeholder="Enter Password" required>
      <button type="submit" name="submit">Login</button>
    </form>
    <a href="register.php">Create an account</a>
    <a href="admin_Login.php">Admin Login</a>
  </div>
</body>
</html>
