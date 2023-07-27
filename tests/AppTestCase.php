<?php declare(strict_types=1);

namespace tests;

use app\App;
use PHPUnit\Framework\TestCase;

class AppTestCase extends TestCase
{
    private function simulateRequest(string $method, string $path): array
    {
        ob_start();
        (new App())->execute($method, $path);
        $output = ob_get_contents();
        ob_end_clean();

        return [
            'headers' => headers_list(),
            'output' => $output,
        ];
    }

    protected function get(string $path, array $params = []): array {
        $_GET = $params;
        $_REQUEST = $params;
        return $this->simulateRequest('get', $path);
    }

    protected function post(string $path, array $params = []): array {
        $_POST = $params;
        $_REQUEST = $params;
        return $this->simulateRequest('post', $path);
    }

    protected function put(string $path, array $params = []): array {
        $_REQUEST = $params;
        return $this->simulateRequest('put', $path);
    }

    protected function patch(string $path, array $params = []): array {
        $_REQUEST = $params;
        return $this->simulateRequest('patch', $path);
    }

    protected function delete(string $path, array $params = []): array {
        $_REQUEST = $params;
        return $this->simulateRequest('delete', $path);
    }
}
