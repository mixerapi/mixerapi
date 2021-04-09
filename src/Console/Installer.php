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
     * @param bool $isTest is this a unit test?
     * @throws \Exception Exception raised by validator.
     * @return mixed
     */
    public static function postInstall(Event $event, $isTest = false)
    {
        $io = $event->getIO();

        if (!$io->isInteractive()) {
            return null;
        }

        if (!self::doInstall($io, $isTest)) {
            return false;
        }

        $ds = DIRECTORY_SEPARATOR;
        $assets = dirname(dirname(__DIR__)) . $ds . 'assets' . $ds;

        if ($isTest) {
            $testsDir = getcwd() . $ds . 'plugins' . $ds . 'mixerapi' . $ds . 'tests' . $ds;
            $userDir = $testsDir . 'installer_output' . $ds;
            $configDir = $testsDir . 'installer_output' . $ds . 'config' . $ds;
        } else {
            $userDir = getcwd();
            $configDir = $userDir . $ds . 'config' . $ds;
        }

        $srcDir = $userDir . 'src' . $ds;

        copy($assets . 'swagger.yml', $configDir . 'swagger.yml');
        copy($assets . 'swagger_bake.php', $configDir . 'swagger_bake.php');
        copy($assets . 'routes.php', $configDir . 'routes.php');
        copy($assets . 'app.php', $configDir . 'app.php');
        copy($assets . 'WelcomeController.php', $srcDir . 'Controller' . $ds . 'WelcomeController.php');
        copy($assets . 'Welcome.php', $srcDir . 'Welcome.php');
        copy($assets . 'Application.php', $srcDir . 'Application.php');

        $io->write('<info>Complete!</info>');

        return true;
    }

    /**
     * Run skeleton install?
     *
     * @param \Composer\IO\IOInterface $io composer IOInterface
     * @param bool $isTest is this a unit test?
     * @return bool
     * @throws \Exception
     */
    private static function doInstall(IOInterface $io, bool $isTest = false): bool
    {
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

        if ($isTest == true) {
            return true;
        }

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
