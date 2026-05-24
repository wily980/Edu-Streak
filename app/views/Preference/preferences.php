<?php
// app/views/Preference/preferences.php
if (empty($_SESSION['user'])) { header('Location: /'); exit; }
$slug = $_GET['lang'] ?? '';
$langName = htmlspecialchars($language['name'] ?? 'this language');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How well do you know <?= $langName ?>?</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="/Edu_Streak_Lock_in/public/css/preferences.css"/>
</head>
<body class="bg">

    <header>
        <div class="top">
            <a href="/Edu_Streak_Lock_in/public/learn"><i class="fa-solid fa-x"></i></a>
        </div>
    </header>

    <main>
        <div class="question">
            <img src="/Edu_Streak_Lock_in/public/assets/robot 1.png" alt="robot">
            <h2>How much do you know about <?= $langName ?>?</h2>
        </div>

        <form action="/Edu_Streak_Lock_in/public/preference" method="POST">
            <input type="hidden" name="lang" value="<?= htmlspecialchars($slug) ?>">
            <input type="hidden" name="level" id="level-input" value="">

            <div class="option">

                <div class="option-text" data-value="1">
                    <img src="/Edu_Streak_Lock_in/public/assets/signal 1.png" alt="level 1">
                    I have no clue gang
                </div>

                <div class="option-text" data-value="2">
                    <img src="/Edu_Streak_Lock_in/public/assets/signal 2.png" alt="level 2">
                    I know some commonly used <?= $langName ?> tags
                </div>

                <div class="option-text" data-value="3">
                    <img src="/Edu_Streak_Lock_in/public/assets/signal 3.png" alt="level 3">
                    I can create simple <?= $langName ?> structures
                </div>

                <div class="option-text" data-value="4">
                    <img src="/Edu_Streak_Lock_in/public/assets/signal 4.png" alt="level 4">
                    I can build pages with various elements
                </div>

                <div class="option-text" data-value="5">
                    <img src="/Edu_Streak_Lock_in/public/assets/signal 5.png" alt="level 5">
                    I can structure <?= $langName ?> pages effectively
                </div>

            </div>

            <footer class="bottom">
                <button type="submit" class="btn-cont" id="btn-cont" disabled>Continue</button>
            </footer>

        </form>
    </main>

    <script>
        const options  = document.querySelectorAll('.option-text');
        const input    = document.getElementById('level-input');
        const btnCont  = document.getElementById('btn-cont');

        options.forEach(opt => {
            opt.addEventListener('click', () => {
                // Remove active from all
                options.forEach(o => o.classList.remove('selected'));

                // Highlight clicked
                opt.classList.add('selected');

                // Set hidden input value
                input.value = opt.dataset.value;

                // Enable continue button
                btnCont.disabled = false;
            });
        });
    </script>

</body>
</html>