<?php
 
namespace App\Core;
 
class Router
{
    private array $routes = [];
 
    public function add(string $method, string $uri, string $controller, string $function)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'function' => $function
        ];
    }
public function run()
{
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === "POST" && isset($_POST['_method'])) {
        $method = strtoupper($_POST['_method']);
    }

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // This strips the project folders so the router only sees "/students"
    $uri = str_replace('/Edu_Streak_Lock_in/public', '', $uri);
    
    // Clean up slashes
    $uri = '/' . trim($uri, '/');

    foreach ($this->routes as $route) {
        $pattern = str_replace('{id}', '([0-9]+)', $route['uri']);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches) && $method === $route['method']) {
            array_shift($matches);

            require_once '../app/controllers/' . $route['controller'] . '.php';
            $controllerClass = 'App\\Controllers\\' . $route['controller'];
            $controller = new $controllerClass();
            $function = $route['function'];

            call_user_func_array([$controller, $function], $matches);
            return;
        }
    }

    http_response_code(404);
    echo '<h1>404 = Page Not Found</h1>';
    echo "Debug: Router could not find match for URI: " . $uri;
}
 
}
 
?>