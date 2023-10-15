<?php declare(strict_types=1);

namespace Cophpee\Components\Cli\Command;

class Help extends AbstractCommand
{
    protected array $commands = [
        'help' => [
            'summary' => 'help',
            'description' => 'Displays help',
        ],
        'init' => [
            'summary' => 'init',
            'description' => 'Initializes a new CoPHPee project',
        ],
    ];

    public function displayHelp(): bool {
        $max = array_reduce($this->commands, fn($carry, $item) => max($carry, strlen($item['summary'])));

        foreach($this->commands as $command) {
            echo str_pad($command['summary'], $max) . " - " . $command['description'] . "\n";
        }

        return true;
    }
}
