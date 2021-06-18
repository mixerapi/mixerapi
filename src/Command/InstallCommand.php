<?php
declare(strict_types=1);

namespace MixerApi\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * MixerApi installer
 */
class InstallCommand extends Command
{
    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('MixerApi Installer')
            ->addOption('auto', [
                'help' => 'Non-interactive install, skips all prompts and uses defaults',
            ])
            ->addOption('test_config_dir', [
                'help' => 'For testing purposes only (don\'t use)',
            ])
            ->addOption('test_src_dir', [
                'help' => 'For testing purposes only (don\'t use)',
            ]);

        return $parser;
    }

    /**
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return int|void|null
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        if ($args->getOption('auto') !== 'Y') {
            $io->hr();
            $io->out('| MixerApi Install');
            $io->hr();

            $io->info('MixerAPI can automatically setup an application skeleton with the following:');
            $io->hr(1);
            $this->printFiles($io);
            $io->hr(1);

            if (strtoupper($io->ask('Continue?', 'Y')) !== 'Y') {
                $io->abort('Install aborted');
            }
        }

        $configDir = defined('CONFIG') ? CONFIG : null;
        $srcDir = defined('APP_DIR') ? APP_DIR . DS : null;

        $configDir = $args->getOption('test_config_dir') ?? $configDir;
        $srcDir = $args->getOption('test_src_dir') ?? $srcDir;

        if (empty($configDir) || empty($srcDir)) {
            $io->abort('Unable to locate config and src directories');
        }

        $assets = __DIR__ . DS . '..' . DS . '..' . DS . 'assets' . DS;

        copy($assets . 'swagger.yml', $configDir . 'swagger.yml');
        copy($assets . 'swagger_bake.php', $configDir . 'swagger_bake.php');
        copy($assets . 'routes.php', $configDir . 'routes.php');
        copy($assets . 'app.php', $configDir . 'app.php');
        copy($assets . 'WelcomeController.php', $srcDir . 'Controller' . DS . 'WelcomeController.php');

        $io->success('MixerApi Installation Complete!');

        if ($args->getOption('auto') === 'Y') {
            $this->printFiles($io);
        }
    }

    /**
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @return void
     */
    private function printFiles(ConsoleIo $io): void
    {
        $overwrite = '<warning> overwrite </warning>';

        $io->out('- config/swagger.yml                        ' . $overwrite);
        $io->out('- config/swagger_bake.php                   ' . $overwrite);
        $io->out('- config/routes.php                         ' . $overwrite);
        $io->out('- config/app.php                            ' . $overwrite);
        $io->out('- src/Controller/WelcomeController.php      ' . $overwrite);
    }
}
