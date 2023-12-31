<?php declare(strict_types=1);

namespace Cophpee\Components\Controller;

class Controller
{
    protected function html(string $html, int $response_code = 200): void
    {
        header('Content-Type: text/html; charset=utf-8');
        http_response_code($response_code);
        echo $html;
    }

    protected function js(string $js, int $response_code = 200): void
    {
        header('Content-Type: text/javascript; charset=utf-8');
        http_response_code($response_code);
        echo $js;
    }

    protected function json(array $data, int $response_code = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($response_code);
        echo json_encode($data);
    }

    protected function close(): void
    {
        header('Connection: close');
    }
}
