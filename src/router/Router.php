<?php declare(strict_types=1);

namespace cophpee\components\router;

class Router
{
    public function __construct(public array $routes) {
    }

    public function route(string $method, string $path): array {
        $routes = array_filter($this->routes, fn($item) => $item['type'] == $method);

        // TODO: cache this
        usort($routes, fn($left, $right) => strcmp($right['uri'], $left['uri']));

        foreach($routes as $route)
        {
            $uri = preg_replace('/\{([^}]+)}/', '(\w+)', $route['uri']);
            if($route['type'] == strtolower($method)
                && preg_match('/' . str_replace('/', '\\/', $uri) . '/', $path, $matches))
            {
                $paramsMatches = array_slice($matches, 1);
                preg_match_all('/\{([^}]+)}/', $route['uri'], $tokenMatches);
                $tokenMatches = $tokenMatches[1];

                $params = [];
                foreach($paramsMatches as $key => $param) {
                    $params[$tokenMatches[$key]] = $param;
                }

                $action = explode('@', $route['method']);
                $controller = $action[0];
                $method = $action[1];
                break;
            }
        }

        return ['controller' => $controller, 'method' => $method, 'params' => $params];
    }
}
