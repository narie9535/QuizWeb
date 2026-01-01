<?php
$conn = new mysqli("localhost", "root", "", "dpproject");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

$update_status = "";

// Handle Delete single question
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $update_status = "Question deleted successfully!";
    } else {
        $update_status = "Failed to delete question!";
    }
    $stmt->close();
}

// Handle Update submission
if (isset($_POST['save_update'])) {
    $id = intval($_POST['id']);
    $question = $_POST['question'];
    $optA = $_POST['optA'];
    $optB = $_POST['optB'];
    $optC = $_POST['optC'];
    $optD = $_POST['optD'];
    $correct = $_POST['correct'];

    $stmt = $conn->prepare("UPDATE questions SET question=?, optA=?, optB=?, optC=?, optD=?, correct=? WHERE id=?");
    $stmt->bind_param("ssssssi", $question, $optA, $optB, $optC, $optD, $correct, $id);

    if ($stmt->execute()) {
        $update_status = "Question updated successfully!";
    } else {
        $update_status = "Failed to update question!";
    }
    $stmt->close();
}

// Handle Truncate All
if (isset($_POST['truncate_all'])) {
    if ($conn->query("TRUNCATE TABLE questions")) {
        $update_status = "All questions deleted successfully!";
    } else {
        $update_status = "Failed to delete all questions!";
    }
}

// Track which row is in edit mode
$edit_id = isset($_POST['update_id']) ? intval($_POST['update_id']) : 0;

// Fetch all questions
$result = $conn->query("SELECT * FROM questions ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Questions</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; padding: 20px; }
header { background: #2c3e50; color: #fff; padding: 20px; text-align: center; font-size: 2rem; font-weight: bold; border-radius: 8px; margin-bottom: 20px; }
h2 { text-align: center; margin-bottom: 10px; color: #333; }
.truncate-btn { display: flex; justify-content: center; margin-bottom: 15px; }
.truncate-btn button { background-color: #e67e22; color: #fff; padding: 8px 15px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; }
.truncate-btn button:hover { background-color: #d35400; }
table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
th, td { padding: 12px 15px; text-align: center; border-bottom: 1px solid #ddd; }
th { background-color: #34495e; color: #fff; text-transform: uppercase; letter-spacing: 0.05em; }
tr:hover { background-color: #f1f1f1; }
button { padding: 6px 12px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: all 0.3s ease; }
button[type="submit"] { background-color: #27ae60; color: #fff; }
button[type="submit"]:hover { background-color: #2ecc71; }
button.delete { background-color: #c0392b; color: #fff; }
button.delete:hover { background-color: #e74c3c; }
input[type="text"] { width: 90%; padding: 5px; border-radius: 5px; border: 1px solid #ccc; }
.actions { display: flex; justify-content: center; gap: 5px; }
</style>
</head>
<body>

<header>Manage Questions</header>

<h2>All Questions</h2>

<!-- Truncate All Button -->
<div class="truncate-btn">
    <form method="POST" onsubmit="return confirm('Are you sure you want to delete all questions?');">
        <button type="submit" name="truncate_all">Delete All Questions</button>
    </form>
</div>

<table>
<tr>
    <th>ID</th>
    <th>Question</th>
    <th>Option A</th>
    <th>Option B</th>
    <th>Option C</th>
    <th>Option D</th>
    <th>Correct</th>
    <th>Actions</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
<?php if ($edit_id === intval($row['id'])): ?>
    <!-- Edit Mode -->
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <td><?php echo $row['id']; ?></td>
        <td><input type="text" name="question" value="<?php echo htmlspecialchars($row['question']); ?>"></td>
        <td><input type="text" name="optA" value="<?php echo htmlspecialchars($row['optA']); ?>"></td>
        <td><input type="text" name="optB" value="<?php echo htmlspecialchars($row['optB']); ?>"></td>
        <td><input type="text" name="optC" value="<?php echo htmlspecialchars($row['optC']); ?>"></td>
        <td><input type="text" name="optD" value="<?php echo htmlspecialchars($row['optD']); ?>"></td>
        <td><input type="text" name="correct" value="<?php echo htmlspecialchars($row['correct']); ?>"></td>
        <td class="actions">
            <button type="submit" name="save_update">Save</button>
        </td>
    </form>
<?php else: ?>
    <!-- Normal Display -->
    <td><?php echo $row['id']; ?></td>
    <td><?php echo htmlspecialchars($row['question']); ?></td>
    <td><?php echo htmlspecialchars($row['optA']); ?></td>
    <td><?php echo htmlspecialchars($row['optB']); ?></td>
    <td><?php echo htmlspecialchars($row['optC']); ?></td>
    <td><?php echo htmlspecialchars($row['optD']); ?></td>
    <td><?php echo htmlspecialchars($row['correct']); ?></td>
    <td class="actions">
        <form method="POST" style="margin: 0;">
            <input type="hidden" name="update_id" value="<?php echo $row['id']; ?>">
            <button type="submit">Update</button>
        </form>
        <form method="GET" style="margin: 0;">
            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="delete" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </td>
<?php endif; ?>
</tr>
<?php } ?>
</table>

<?php if (!empty($update_status)): ?>
<script>
alert("<?php echo addslashes($update_status); ?>");
window.location.href = window.location.href.split('?')[0]; // Remove query params after alert
</script>
<?php endif; ?>

</body>
</html>

<?php $conn->close(); ?>
