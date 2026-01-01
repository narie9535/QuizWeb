<?php
session_start();

// ✅ Default credentials
$USERNAME = "vinay";
$PASSWORD = "vinay@123";

// Handle login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST["username"]);
    $pass = trim($_POST["password"]);

    if ($user === $USERNAME && $pass === $PASSWORD) {
        $_SESSION["logged_in"] = true;
        // Redirect admin to result_board.php after login
        header("Location: admin_dashBoard.php");
        exit;
    } else {
        $error = "❌ Invalid username or password!";
    }
}

// Handle logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: linear-gradient(to right, #ff416c, #ff4b2b);
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.container {
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
  width: 300px;
  text-align: center;
}
h2 {
  margin-bottom: 20px;
  color: #333;
}
input[type="text"], input[type="password"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
}
button {
  width: 100%;
  padding: 12px;
  border: none;
  border-radius: 8px;
  background: linear-gradient(45deg, #6a11cb, #2575fc);
  color: #fff;
  font-size: 1em;
  cursor: pointer;
}
button:hover {
  background: linear-gradient(45deg, #ff416c, #ff4b2b);
}
.error {
  background: #ffcdd2;
  color: #b71c1c;
  padding: 8px;
  border-radius: 6px;
  margin-bottom: 15px;
}
</style>
</head>
<body>

<div class="container">
  <h2>Admin Login</h2>
  <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
  <form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</div>

</body>
</html>
