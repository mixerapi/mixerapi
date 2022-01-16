<?php
declare(strict_types=1);

namespace MixerApi\Service;

use MixerApi\Exception\InstallException;

/**
 * MixerAPI Installer Service
 */
class InstallerService
{
    private array $files;

    /**
     * @param string|null $assetsDir Where the assets to be copied are located. If null the path will be determined
     * automatically.
     * @param string|null $rootDir The project's root directory. If null then the ROOT constant will be used.
     */
    public function __construct(
        private ?string $assetsDir = null,
        private ?string $rootDir = null,
    ) {
        $this->assetsDir = $this->assetsDir ?? __DIR__ . DS . '..' . DS . '..' . DS . 'assets' . DS;
        // @phpstan-ignore-next-line ignore Constant ROOT not found.
        $this->rootDir = $this->rootDir ?? ROOT . DS;
        $config = $this->rootDir . 'config' . DS;

        $this->files = [
            'swaggerbake' => [
                'name' => 'SwaggerBake config',
                'source' => $this->assetsDir . 'swagger_bake.php',
                'destination' => $config . 'swagger_bake.php',
            ],
            'openapi' => [
                'name' => 'OpenAPI YAML',
                'source' => $this->assetsDir . 'swagger.yml',
                'destination' => $config . 'swagger.yml',
            ],
            'routes' => [
                'name' => 'CakePHP routes',
                'source' => $this->assetsDir . 'routes.php',
                'destination' => $config . 'routes.php',
            ],
            'config' => [
                'name' => 'CakePHP config',
                'source' => $this->assetsDir . 'app.php',
                'destination' => $config . 'app.php',
            ],
            'welcome' => [
                'name' => 'WelcomeController',
                'source' => $this->assetsDir . 'WelcomeController.php',
                'destination' => $this->rootDir . 'src' . DS . 'Controller' . DS . 'WelcomeController.php',
            ],
        ];
    }

    /**
     * Copy files.
     *
     * @param array $file An item from InstallerService::files.
     * @return void
     * @throws \MixerApi\Exception\InstallException
     */
    public function copyFile(array $file): void
    {
        if (!file_exists($file['source'])) {
            throw new InstallException(
                sprintf(
                    InstallException::SOURCE_FILE_MISSING,
                    $file['source']
                )
            );
        }
        if (file_exists($file['destination'])) {
            throw (new InstallException(
                sprintf(
                    InstallException::DESTINATION_FILE_EXISTS,
                    $file['name'],
                    $file['destination']
                )
            ))->setCanContinue(true)->setCanCopy(true);
        }
        $this->copy($file);
    }

    /**
     * Copy the file.
     *
     * @param array $file An item from InstallerService::files.
     * @return bool
     */
    public function copy(array $file): bool
    {
        if (!@copy($file['source'], $file['destination'])) { // phpcs:ignore
            throw new InstallException(
                sprintf(
                    InstallException::COPY_FAILED,
                    $file['source'],
                    $file['destination'],
                )
            );
        }

        return true;
    }

    /**
     * Returns an array of files to be copied.
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}
