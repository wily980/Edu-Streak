<?php if (!defined('BASE_URL')) require_once '../app/config/app.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edustreak</title>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;700;900&family=Spectral:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
</head>
<body>

    <header class="navbar">
        <div class="logo">
            <img src="<?= BASE_URL ?>/assets/Logoutama.png" alt="logo">
            <span>Edustreak</span>
        </div>
        <div class="language">
            Language: English ▼
        </div>
    </header>

    <section class="hero">
        <div class="left">
            <img src="<?= BASE_URL ?>/assets/Edustreakmain.png" alt="coding icons">
        </div>

        <div class="right">
            <h1>10 lines a day keeps the syntax errors away.</h1>

            <a href="<?= BASE_URL ?>/auth/google">
                <button class="btn-start">Get Started</button>
            </a>

            <a href="<?= BASE_URL ?>/auth/google">
                <button class="btn-login">I already have an account</button>
            </a>
        </div>
    </section>

    <footer class="footer">
        <div class="icons">
            <div class="icon-track">
                <img src="<?= BASE_URL ?>/assets/python.png">
                <img src="<?= BASE_URL ?>/assets/java.png">
                <img src="<?= BASE_URL ?>/assets/js.png">
                <img src="<?= BASE_URL ?>/assets/Csharp.png">
                <img src="<?= BASE_URL ?>/assets/C++.png">
                <img src="<?= BASE_URL ?>/assets/TS.png">
                <img src="<?= BASE_URL ?>/assets/php.png">
                <img src="<?= BASE_URL ?>/assets/html.png">
                <img src="<?= BASE_URL ?>/assets/css.png">
            </div>
            <div class="icon-track">
                <img src="<?= BASE_URL ?>/assets/python.png">
                <img src="<?= BASE_URL ?>/assets/java.png">
                <img src="<?= BASE_URL ?>/assets/js.png">
                <img src="<?= BASE_URL ?>/assets/Csharp.png">
                <img src="<?= BASE_URL ?>/assets/C++.png">
                <img src="<?= BASE_URL ?>/assets/TS.png">
                <img src="<?= BASE_URL ?>/assets/php.png">
                <img src="<?= BASE_URL ?>/assets/html.png">
                <img src="<?= BASE_URL ?>/assets/css.png">
            </div>
            <div class="icon-track">
                <img src="<?= BASE_URL ?>/assets/python.png">
                <img src="<?= BASE_URL ?>/assets/java.png">
                <img src="<?= BASE_URL ?>/assets/js.png">
                <img src="<?= BASE_URL ?>/assets/Csharp.png">
                <img src="<?= BASE_URL ?>/assets/C++.png">
                <img src="<?= BASE_URL ?>/assets/TS.png">
                <img src="<?= BASE_URL ?>/assets/php.png">
                <img src="<?= BASE_URL ?>/assets/html.png">
                <img src="<?= BASE_URL ?>/assets/css.png">
            </div>
        </div>
    </footer>

</body>
</html>