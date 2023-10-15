<?php declare(strict_types=1);

namespace Cophpee\Components\Cli\Command;

abstract class AbstractCommand
{
    public function __construct(public array $args)
    {
    }

    protected function ensurePathExists(string $path): void
    {
        if(!is_dir($path)) {
            mkdir($path);
        }
    }

}
