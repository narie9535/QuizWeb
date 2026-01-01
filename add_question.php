<?php
$message = ""; // to show success or error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ ONLY CHANGE: DB credentials written using variables (as you told)
    $servername = "sql300.infinityfree.com"; 
    $username   = "if0_40559030";     
    $password   = "JJ7DIjbbfg2f7pp";          
    $dbname     = "if0_40559030_quize_data"; 

    $conn = new mysqli($servername, $username, $password, $dbname);
    // ✅ END OF CHANGE

    if ($conn->connect_error) {
        die("DB Connection failed: " . $conn->connect_error);
    }

    $question = trim($_POST['question']);
    $optA = trim($_POST['optA']);
    $optB = trim($_POST['optB']);
    $optC = trim($_POST['optC']);
    $optD = trim($_POST['optD']);
    $correct = strtoupper(trim($_POST['correct']));

    if ($question && $optA && $optB && $optC && $optD && in_array($correct, ['A', 'B', 'C', 'D'])) {
        $stmt = $conn->prepare(
            "INSERT INTO questions (question, optA, optB, optC, optD, correct)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssss", $question, $optA, $optB, $optC, $optD, $correct);

        if ($stmt->execute()) {
            $message = "<div class='success'>✅ Question saved successfully!</div>";
        } else {
            $message = "<div class='error'>❌ Failed to save question. Try again.</div>";
        }

        $stmt->close();
    } else {
        $message = "<div class='warning'>⚠️ Please fill all fields and ensure correct answer is A/B/C/D.</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Aptitude Question</title>

<style>
body {
  font-family: "Segoe UI", Arial, sans-serif;
  background: linear-gradient(to right, #ff416c, #ff4b2b);
  margin: 0;
  padding: 0;
}

header {
  background: #1a1a2e;
  color: white;
  text-align: center;
  padding: 20px;
  font-size: 1.8em;
  font-weight: bold;
}

.container {
  max-width: 600px;
  margin: 40px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

label {
  display: block;
  margin-top: 12px;
  font-weight: bold;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-top: 6px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

button {
  width: 100%;
  margin-top: 25px;
  padding: 12px;
  border: none;
  border-radius: 8px;
  background: linear-gradient(45deg, #6a11cb, #2575fc);
  color: #fff;
  font-size: 1.1em;
}

.success {
  background: #c8e6c9;
  padding: 10px;
  margin-bottom: 15px;
  text-align: center;
}

.error {
  background: #ffcdd2;
  padding: 10px;
  margin-bottom: 15px;
  text-align: center;
}

.warning {
  background: #fff3cd;
  padding: 10px;
  margin-bottom: 15px;
  text-align: center;
}
</style>
</head>

<body>

<header>Add One Aptitude Question</header>

<div class="container">
  <?php echo $message; ?>

  <form method="POST">
    <label>Question</label>
    <input type="text" name="question" required>

    <label>Option A</label>
    <input type="text" name="optA" required>

    <label>Option B</label>
    <input type="text" name="optB" required>

    <label>Option C</label>
    <input type="text" name="optC" required>

    <label>Option D</label>
    <input type="text" name="optD" required>

    <label>Correct Answer (A/B/C/D)</label>
    <input type="text" name="correct" maxlength="1" required>

    <button type="submit">Save Question</button>
  </form>
</div>

</body>
</html>
