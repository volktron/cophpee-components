<?php declare(strict_types=1);

namespace Cophpee\Components\Facade;

use Exception;

class SESSION
{
    /**
     * @throws Exception
     */
    public static function init($config): void {
        if(empty($config['name'])) {
            throw new Exception('Session cannot be initialized without a name');
        }

        session_name($config['name']);
        session_start();
    }

    public static function destroy(): void {
        $_SESSION = [];
        session_destroy();
    }
}
