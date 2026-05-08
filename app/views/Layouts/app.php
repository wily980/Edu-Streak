<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,400;0,700;1,400&family=Unbounded:wght@200;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/output.css">
</head>
<body class="min-h-screen flex flex-col bg-gray-100">
    <?php require_once '../app/views/Layouts/partials/header.php' ?>
 
    <main class="grow container mx-auto">
        <?php if (isset($content)) {
            require_once $content;
        } ?>
    </main>
    <?php require_once '../app/views/Layouts/partials/footer.php' ?>
</body>
</html>