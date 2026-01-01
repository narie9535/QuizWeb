<?php
$conn = new mysqli("localhost", "root", "", "dpproject");
if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle truncate button
if (isset($_POST['clear_all'])) {
    if ($conn->query("TRUNCATE TABLE results")) {
        $message = "<div class='success'>✅ All records cleared successfully!</div>";
    } else {
        $message = "<div class='error'>❌ Failed to clear records!</div>";
    }
}

// Fetch results sorted by score DESC
$results = $conn->query("SELECT username, email, score FROM results ORDER BY score DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Aptitude Quiz Leaderboard</title>
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
  margin: 50px auto;
  background: #fff;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

h2 {
  text-align: center;
  color: #243b55;
  margin-bottom: 25px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: center;
}

th {
  background: #1a1a2e;
  color: #fff;
}

tr:nth-child(even) {
  background: #f9f9f9;
}

tr:hover {
  background: #ffe6e6;
}

button {
  display: block;
  margin: 20px auto;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
  font-size: 1em;
  cursor: pointer;
  background: linear-gradient(45deg, #e53935, #e35d5b);
  color: white;
  transition: 0.3s;
}

button:hover {
  background: linear-gradient(45deg, #ff416c, #ff4b2b);
}

.success {
  background: #c8e6c9;
  color: #256029;
  padding: 10px;
  border-radius: 6px;
  text-align: center;
  margin-bottom: 15px;
}

.error {
  background: #ffcdd2;
  color: #b71c1c;
  padding: 10px;
  border-radius: 6px;
  text-align: center;
  margin-bottom: 15px;
}
</style>
<script>
function confirmClear() {
  return confirm("⚠️ Are you sure you want to delete all records?");
}
</script>
</head>
<body>

<header>Aptitude Quiz Leaderboard</header>

<div class="container">
  <h2>Top Scorers</h2>

  <?php echo $message; ?>

  <table>
    <tr>
      <th>Rank</th>
      <th>Name</th>
      <th>Email</th>
      <th>Score</th>
    </tr>

    <?php
    $rank = 1;
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            echo "<tr>
                    <td>{$rank}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td><b>{$row['score']}</b></td>
                  </tr>";
            $rank++;
        }
    } else {
        echo "<tr><td colspan='4'>No results yet.</td></tr>";
    }

    $conn->close();
    ?>
  </table>

  <form method="POST" onsubmit="return confirmClear();">
    <button type="submit" name="clear_all">🗑 Clear All Records</button>
  </form>
</div>

</body>
</html>
