<?php
session_start();

include 'config.php';

$name = $email = ""; // to retain values in case of error

if (isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $email = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];
    $Cpassword = $_POST["Cpassword"];

    // Check for duplicate email using prepared statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists! Please use another email.');</script>";
    } else {
        if ($password === $Cpassword) {
            // Insert user using prepared statement
            $insert = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $name, $email, $password);
            $insert->execute();

            // Redirect after successful registration
            header("Location: quize1.php");
            exit;
        } else {
            echo "<script>alert('Passwords do not match');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #ff9966, #ff5e62);
    }

    .register-box {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      width: 380px;
      text-align: center;
    }

    h2 {
      margin-bottom: 20px;
      color: #333;
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 5px;
      font-size: 14px;
      color: #444;
    }

    input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      transition: 0.3s;
    }

    input:focus {
      border-color: #ff5e62;
      box-shadow: 0 0 8px rgba(255,94,98,0.3);
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(90deg, #ff9966, #ff5e62);
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: linear-gradient(90deg, #ff5e62, #ff9966);
      transform: scale(1.05);
    }

    a {
      display: block;
      margin-top: 15px;
      color: #ff5e62;
      text-decoration: none;
      font-size: 14px;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>Registration</h2>
    <form action="" method="post" autocomplete="off">
      <label for="name">Name :</label>
      <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>

      <label for="email">Email :</label>
      <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

      <label for="password">Password :</label>
      <input type="password" name="password" id="password" required>

      <label for="Cpassword">Confirm Password :</label>
      <input type="password" name="Cpassword" id="Cpassword" required>

      <button type="submit" name="submit">Register</button>
    </form>
    <a href="Login.php">Already have an account? Login</a>
  </div>
</body>
</html>
