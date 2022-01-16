<?php
declare(strict_types=1);

namespace MixerApi\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use MixerApi\Exception\InstallException;
use MixerApi\Service\InstallerService;

/**
 * MixerApi installer
 */
class InstallCommand extends Command
{
    public const DONE = 'MixerAPI Installation Complete!';

    /**
     * @param \MixerApi\Service\InstallerService $installerService The MixerAPI installer service
     */
    public function __construct(private InstallerService $installerService)
    {
        parent::__construct();
    }

    /**
     * @param \Cake\Console\ConsoleOptionParser $parser ConsoleOptionParser
     * @return \Cake\Console\ConsoleOptionParser
     */
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser
            ->setDescription('MixerAPI Installer')
            ->addOption('auto', [
                'help' => 'Non-interactive install, skips all prompts and uses defaults',
                'default' => 'N',
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
        $io->info('Installing MixerAPI');

        $isAuto = $args->getOption('auto') == 'Y';

        foreach ($this->installerService->getFiles() as $file) {
            try {
                $this->installerService->copyFile($file);
                $this->copied($io, $file);
            } catch (InstallException $e) {
                if ($e->canCopy() && ($isAuto || $io->ask($e->getMessage(), 'Y') == 'Y')) {
                    $this->installerService->copy($file);
                    $this->copied($io, $file);
                    continue;
                } elseif (!$e->canContinue()) {
                    $io->abort($e->getMessage());
                }
            }
        }

        $io->success(self::DONE);
    }

    /**
     * Writes message to console on copy.
     *
     * @param \Cake\Console\ConsoleIo $io ConsoleIo
     * @param array $file The file array
     * @return void
     */
    private function copied(ConsoleIo $io, array $file): void
    {
        $io->out(sprintf(
            'Copied %s to %s',
            $file['name'],
            $file['destination']
        ));
        $io->hr();
    }
}
