<?php declare(strict_types=1);

namespace Cophpee\Components\Cli\Command;

class Init extends AbstractCommand
{
    public function init(): bool {
        $cwd = getcwd();
        $vendorDirectory = getcwd() . DIRECTORY_SEPARATOR . 'vendor';
        $cophpeeDirectory = $vendorDirectory . DIRECTORY_SEPARATOR . 'volktron' . DIRECTORY_SEPARATOR . 'cophpee';

        echo "Initializing new CoPHPee project\n";

        foreach([ // TODO: do a recursive directory scan instead of using hardcoded array of files
            'cophpee',
            'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'IndexController.php',
            'app' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'routes.php',
            'app' . DIRECTORY_SEPARATOR . 'bootstrap.php',
            'configs' . DIRECTORY_SEPARATOR . 'examples' . DIRECTORY_SEPARATOR . 'databases.php',
            'public' . DIRECTORY_SEPARATOR . '.htaccess',
            'public' . DIRECTORY_SEPARATOR . 'index.php',
            'tests' . DIRECTORY_SEPARATOR . 'endpoints' . DIRECTORY_SEPARATOR . 'IndexControllerTest.php'
        ] as $file) {
            $this->ensurePathExists(dirname($file));
            copy(
                $cophpeeDirectory . DIRECTORY_SEPARATOR . $file,
                $cwd . DIRECTORY_SEPARATOR . $file
            );
        }

        echo "Done\n";

        return true;
    }
}
