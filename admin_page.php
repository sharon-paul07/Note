<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #dde4f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 28px;
            box-shadow: 0 20px 60px rgba(91,115,245,0.18);
            text-align: center;
            width: 400px;
        }
        h1 {
            color: #2d2d3a;
            margin-bottom: 10px;
        }
        p {
            color: #9395a5;
            margin-bottom: 30px;
        }
        .badge {
            background: #e2e6ff;
            color: #5B73F5;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 20px;
        }
        .logout-btn {
            display: inline-block;
            background: #5B73F5;
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #4a60e0;
        }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Admin Portal</span>
        <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
        <p>You have successfully logged in to the Administrative Dashboard.</p>
        <a href="logout.php" class="logout-btn">Log Out</a>
    </div>
</body>
</html>
