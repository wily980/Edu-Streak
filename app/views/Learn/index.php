<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I want to Learn - Edustreak</title>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;700;900&family=Spectral:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/output.css">
</head>
<body>

    <header class="navbar">
        <div class="logo">
            <img src="/assets/Logoutama.png" alt="logo">
            <span>Edustreak</span>
        </div>
        <div class="language">
            Language: English ▼
        </div>
    </header>

    <section class="learn-section">
        <h1 class="learn-title">I want to Learn..</h1>

        <form method="POST" action="/learn">
            <div class="language-grid">
                <?php if (!empty($languages) && is_array($languages)): ?>
                    <?php foreach ($languages as $lang): ?>
                    <label class="language-card" for="lang-<?= $lang['id'] ?>">
                        <input 
                            type="radio" 
                            name="language_id" 
                            id="lang-<?= $lang['id'] ?>" 
                            value="<?= $lang['id'] ?>"
                            hidden
                        >
                        <img src="<?= $lang['icon_url'] ?>" alt="<?= $lang['name'] ?>">
                        <h3><?= $lang['name'] ?></h3>
                    </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No languages available.</p>
                <?php endif; ?>
            </div>

            <div class="learn-btn-wrap">
                <button type="submit" class="btn-start">Let's Go!</button>
            </div>
        </form>
    </section>

</body>
</html>