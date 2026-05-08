<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Edustreak</title>
    <link rel="stylesheet" href="/Edu_Streak_Lock_in/public/css/output.css">
</head>
<body>
    <h1>Welcome, <?= $_SESSION['user']['name'] ?? 'Student' ?>!</h1>
    <p>Email: <?= $_SESSION['user']['email'] ?? '' ?></p>
    <a href="/Edu_Streak_Lock_in/public/auth/logout">Logout</a>
</body>
</html>