<?php
namespace App\Core;

class controllers
{
    public function view(string $view, array $data = [])
    {
        extract($data);
        $view = str_replace(
            '.', '/', $view
            );
        $content = "../app/views/{$view}.php";

        require_once '../app/views/layouts/app.php';
    }
}
?>