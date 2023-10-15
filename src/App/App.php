<?php declare(strict_types=1);

namespace Cophpee\Components\App;

use Cophpee\Components\Facade\DB;
use Cophpee\Components\Router\Router;
use Throwable;

class App
{
    protected Router $router;

    public function __construct(protected array $config)
    {
        // Handle request data. GET and POST requests already get handled by PHP
        if($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_REQUEST = file_get_contents("php://input");
        }

        // Initialize things.
        DB::init($config['db'] ?? []);
        $this->router = new Router($config['routes'] ?? []);
    }

    public function execute(string $method, string $path = ''): void
    {
        try {
            $route = $this->router->route($method, $path);
            $controllerName = '\app\controllers\\' . $route['controller'];
            $controller = new $controllerName();
            call_user_func_array([$controller, $route['method']], $route['params']);
        } catch (Throwable $throwable) {
            if($this->config['mode'] == 'development') {
                // TODO: proper error handling, logging
                echo '<pre>';
                var_dump($throwable->getMessage());
                var_dump(debug_backtrace());
                echo '</pre>';
            }
        }
    }
}
