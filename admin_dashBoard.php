<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
/* Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f0f2f5;
  color: #333;
}

header {
  background: linear-gradient(90deg, #ff4b2b, #ff416c);
  color: #fff;
  padding: 1.5rem;
  text-align: center;
  font-size: 2rem;
  font-weight: bold;
  letter-spacing: 1px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.dashboard {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 2rem;
  padding: 3rem 1rem;
}

/* Card Styling */
.card {
  background: #fff;
  border-radius: 15px;
  width: 250px;
  height: 150px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  cursor: pointer;
  transition: all 0.4s ease;
  position: relative;
  overflow: hidden;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  border: 2px solid transparent;
}

.card::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(255,75,43,0.2), rgba(255,65,108,0.2));
  top: -100%;
  left: -100%;
  transition: all 0.5s ease;
  transform: rotate(45deg);
}

.card:hover::before {
  top: 0;
  left: 0;
}

.card:hover {
  transform: translateY(-10px) scale(1.05);
  box-shadow: 0 12px 25px rgba(0,0,0,0.25);
  border: 2px solid #ff416c;
}

.card h3 {
  z-index: 1;
  font-size: 1.4rem;
  color: #333;
  transition: color 0.3s;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.card:hover h3 {
  color: #ff416c;
}

/* Responsive */
@media (max-width: 768px) {
  .dashboard {
    flex-direction: column;
    gap: 1.5rem;
    padding: 2rem 1rem;
  }
}
</style>
</head>
<body>

<header>Admin Dashboard</header>

<div class="dashboard">
  <div class="card" onclick="location.href='update_question.php'">
    <h3><span>📋</span> Manage Questions</h3>
  </div>

  <div class="card" onclick="location.href='add_question.php'">
    <h3><span>➕</span> Add Questions</h3>
  </div>

  <div class="card" onclick="location.href='result_board.php'">
    <h3><span>📊</span> View Results</h3>
  </div>
</div>

</body>
</html>
