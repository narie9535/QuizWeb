<?php
$message = ""; // to show success or error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "dpproject");

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
        $stmt = $conn->prepare("INSERT INTO questions (question, optA, optB, optC, optD, correct) VALUES (?, ?, ?, ?, ?, ?)");
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

<!-- ---------------- FRONTEND ---------------- -->
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
  letter-spacing: 1px;
}

.container {
  max-width: 600px;
  margin: 40px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

h2 {
  text-align: center;
  color: #243b55;
  margin-bottom: 25px;
}

label {
  display: block;
  margin-top: 12px;
  margin-bottom: 6px;
  font-weight: bold;
  color: #333;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1em;
  transition: border-color 0.2s;
}

input[type="text"]:focus {
  border-color: #6a11cb;
  box-shadow: 0 0 6px rgba(106,17,203,0.4);
  outline: none;
}

button {
  display: block;
  width: 100%;
  margin-top: 25px;
  padding: 12px;
  border: none;
  border-radius: 8px;
  background: linear-gradient(45deg, #6a11cb, #2575fc);
  color: #fff;
  font-size: 1.1em;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  background: linear-gradient(45deg, #ff416c, #ff4b2b);
}

.note {
  text-align: center;
  margin-top: 10px;
  color: #555;
  font-size: 0.9em;
}

.success {
  text-align: center;
  background: #c8e6c9;
  color: #256029;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}

.error {
  text-align: center;
  background: #ffcdd2;
  color: #b71c1c;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}

.warning {
  text-align: center;
  background: #fff3cd;
  color: #856404;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}
</style>
</head>
<body>

<header>Add One Aptitude Question</header>

<div class="container">
  <h2>Enter Question Details</h2>

  <!-- ✅ message box -->
  <?php echo $message; ?>

  <form method="POST" action="">
    <label>Question:</label>
    <input type="text" name="question" placeholder="Enter your question" required>

    <label>Option A:</label>
    <input type="text" name="optA" placeholder="Enter option A" required>

    <label>Option B:</label>
    <input type="text" name="optB" placeholder="Enter option B" required>

    <label>Option C:</label>
    <input type="text" name="optC" placeholder="Enter option C" required>

    <label>Option D:</label>
    <input type="text" name="optD" placeholder="Enter option D" required>

    <label>Correct Answer (A/B/C/D):</label>
    <input type="text" name="correct" placeholder="Enter A/B/C/D" maxlength="1" required>

    <button type="submit">✅ Save Question</button>
  </form>

  <p class="note">Each submission saves one question in the database.</p>
</div>

</body>
</html>
