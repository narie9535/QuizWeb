<?php
include 'config.php';
$score = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Fetch questions and correct answers
    $questions = $conn->query("SELECT id, correct FROM questions");

    if ($questions->num_rows > 0) {
        while ($row = $questions->fetch_assoc()) {
            $qid = $row['id'];
            $correct = strtoupper(trim($row['correct']));
            $userAnswer = isset($_POST["answer_$qid"]) ? strtoupper(trim($_POST["answer_$qid"])) : "";

            if ($userAnswer === $correct) {
                $score++;
            }
        }

        // Create results table if not exists
        $conn->query("CREATE TABLE IF NOT EXISTS results (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100),
            email VARCHAR(100),
            score INT,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Insert result
        $stmt = $conn->prepare("INSERT INTO results (username, email, score) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $email, $score);
        $stmt->execute();

        // Redirect to final.html
        header("Location: final.html");
        exit;
    }
}

// Fetch questions for the quiz
$result = $conn->query("SELECT id, question, optA, optB, optC, optD FROM questions ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aptitude Quiz</title>
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
  max-width: 800px;
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
  font-weight: bold;
  color: #333;
}

input[type="text"], input[type="email"] {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1em;
  margin-bottom: 12px;
}

.question {
  margin-bottom: 25px;
  padding: 15px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.options label {
  display: block;
  margin-bottom: 6px;
  cursor: pointer;
}

button {
  display: block;
  width: 100%;
  margin-top: 20px;
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
</style>
</head>
<body>

<header>Aptitude Quiz</header>

<div class="container">
  <h2>Participant Details</h2>

  <form method="POST" action="">
    <label>Your Name:</label>
    <input type="text" name="username" placeholder="Enter your full name" required>

    <label>Your Email:</label>
    <input type="email" name="email" placeholder="Enter your email" required>

    <h2>Answer the Questions</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='question'>
              <p><b>Q{$row['id']}. {$row['question']}</b></p>
              <div class='options'>
                <label><input type='radio' name='answer_{$row['id']}' value='A' required> A) {$row['optA']}</label>
                <label><input type='radio' name='answer_{$row['id']}' value='B'> B) {$row['optB']}</label>
                <label><input type='radio' name='answer_{$row['id']}' value='C'> C) {$row['optC']}</label>
                <label><input type='radio' name='answer_{$row['id']}' value='D'> D) {$row['optD']}</label>
              </div>
            </div>";
        }
    } else {
        echo "<p>No questions available right now.</p>";
    }
    ?>

    <button type="submit" name="submit">✅ Submit Quiz</button>
  </form>
</div>

</body>
</html>
