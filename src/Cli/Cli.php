<?php declare(strict_types=1);

namespace Cophpee\Components\Cli;

use Cophpee\Components\Cli\Command\Help;
use Cophpee\Components\Cli\Command\Init;

class Cli
{
    protected array $args;
    protected string $command;

    public function __construct()
    {
        $this->args = $_SERVER['argv'];
        $this->command = $this->args[1] ?? '';
    }

    public function processCommand(): bool
    {
        return match($this->command) {
            'init'  => (new Init($this->args))->init(),
            default  => (new Help($this->args))->displayHelp(),
        };
    }
}