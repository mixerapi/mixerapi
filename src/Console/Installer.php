<?php
declare(strict_types=1);

namespace MixerApi\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

use Composer\IO\IOInterface;
use Composer\Script\Event;
use Exception;

/**
 * Provides installation hooks for when this application is installed through
 * composer. Customize this class to suit your needs.
 */
class Installer
{
    /**
     * MixerApi welcome installer
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     * @return void
     */
    public static function postInstall(Event $event): void
    {
        $io = $event->getIO();

        if (!self::doInstall($io)) {
            return;
        }

        $rootDir = dirname(dirname(__DIR__));
        $userDir = getcwd();

        $ds = DIRECTORY_SEPARATOR;
        $assets = $rootDir . $ds . 'assets' . $ds;

        $config = $userDir . $ds . 'config' . $ds;
        $src = $userDir . $ds . 'src' . $ds;

        copy($assets . 'swagger.yml', $config . 'swagger.yml');
        copy($assets . 'swagger_bake.php', $config . 'swagger_bake.php');
        copy($assets . 'routes.php', $config . 'routes.php');
        copy($assets . 'app.php', $config . 'app.php');
        copy($assets . 'WelcomeController.php', $src . 'Controller' . $ds . 'WelcomeController.php');
        copy($assets . 'Welcome.php', $src . 'Welcome.php');
        copy($assets . 'Application.php', $src . 'Application.php');

        $io->write('<info>Complete!</info>');
    }

    /**
     * Run skeleton install?
     *
     * @param \Composer\IO\IOInterface $io composer IOInterface
     * @return bool
     * @throws \Exception
     */
    private static function doInstall(IOInterface $io): bool
    {
        if (!$io->isInteractive()) {
            return false;
        }

        $overwrite = '<warning> overwrite </warning>';

        $io->write('<info>MixerAPI can automatically setup an application skeleton with the following:</info>');
        $io->write('---');
        $io->write('- config/swagger.yml                        ' . $overwrite);
        $io->write('- config/swagger_bake.php                   ' . $overwrite);
        $io->write('- config/routes.php                         ' . $overwrite);
        $io->write('- config/app.php                            ' . $overwrite);
        $io->write('- src/Controller/WelcomeController.php      ' . $overwrite);
        $io->write('- src/Welcome.php                           ' . $overwrite);
        $io->write('- src/Application.php                       ' . $overwrite);
        $io->write('---');

        $question = 'Run MixerApi application skeleton? (Default to N)';

        $answer = $io->askAndValidate(
            "<info>$question</info> [<comment>Y,n</comment>]? ",
            function ($arg) {
                if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                    return $arg;
                }
                throw new Exception('This is not a valid answer. Please choose Y or n.');
            },
            10,
            'n'
        );

        return in_array($answer, ['y', 'Y']);
    }
}
