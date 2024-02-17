<?php

namespace MixerApi\Test\TestCase\Command;

use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Command\InstallCommand;
use MixerApi\Exception\InstallException;
use MixerApi\Service\InstallerService;

class InstallCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;
    // @phpstan-ignore-next-line ignore Constant ROOT not found.
    private const MIXERAPI = ROOT . DS . 'plugins' . DS . 'mixerapi' . DS;

    public function setUp(): void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Test\App');
        $outputDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS;
        @unlink($outputDir . 'config' . DS . 'swagger.yml');
        @unlink($outputDir . 'config' . DS . 'swagger_bake.php');
        @unlink($outputDir . 'config' . DS . 'routes.php');
        @unlink($outputDir . 'config' . DS . 'app.php');
        @unlink($outputDir . 'src' . DS . 'Controller' . DS . 'WelcomeController.php');
    }

    public function test_auto_install(): void
    {
        $installer =  new InstallerService(
            self::MIXERAPI . 'assets' . DS,
            self::MIXERAPI . 'tests' . DS . 'installer_output' . DS,
        );
        $this->mockService(InstallerService::class, function () use ($installer) {
            return $installer;
        });

        $this->exec('mixerapi install --auto Y');

        $assetsDir = self::MIXERAPI . 'assets' . DS;
        $configDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS . 'config' . DS;

        $this->assertFileExists($configDir . 'swagger.yml');
        $this->assertFileEquals($assetsDir . 'swagger.yml', $configDir . 'swagger.yml');

        $this->assertFileExists($configDir . 'routes.php');
        $this->assertFileEquals($assetsDir . 'routes.php',$configDir . 'routes.php');

        $this->assertFileExists($configDir . 'app.php');
        $this->assertFileEquals($assetsDir . 'app.php',$configDir . 'app.php');

        $srcDir = self::MIXERAPI . 'tests' . DS . 'installer_output' . DS . 'src' . DS;

        $this->assertFileExists($srcDir . 'Controller' . DS . 'WelcomeController.php');
        $this->assertFileEquals(
            $assetsDir . 'WelcomeController.php',
            $srcDir . 'Controller' . DS . 'WelcomeController.php'
        );
        $this->assertOutputContains(InstallCommand::DONE);
    }

    public function test_auto_install_with_continuable_exception(): void
    {
        $mockInstaller = $this->getMockBuilder(InstallerService::class)
            ->setConstructorArgs([
                self::MIXERAPI . 'assets' . DS,
                self::MIXERAPI . 'tests' . DS . 'installer_output' . DS,
            ])
            ->onlyMethods([
                'copyFile',
                'getFiles',
                'copy'
            ])
            ->getMock();

        $mockInstaller->method('copyFile')
            ->withAnyParameters()
            ->willThrowException((new InstallException())->setCanContinue(true)->setCanCopy(true));

        $mockInstaller->method('copy')
            ->withAnyParameters()
            ->willReturn(true);

        $mockInstaller->method('getFiles')
            ->withAnyParameters()
            ->willReturn([
                'test' => [
                    'name' => 'Test',
                    'source' => __FILE__,
                    'destination' => '/tmp/' . md5((string) microtime(true)),
                ]
            ]);

        $this->mockService(InstallerService::class, function () use ($mockInstaller) {
            return $mockInstaller;
        });

        $this->exec('mixerapi install', ['Y']);
        $this->assertOutputContains(InstallCommand::DONE);
    }

    public function test_auto_install_with_exception(): void
    {
        $mockInstaller = $this->getMockBuilder(InstallerService::class)
            ->setConstructorArgs([
                self::MIXERAPI . 'assets' . DS,
                self::MIXERAPI . 'tests' . DS . 'installer_output' . DS,
            ])
            ->onlyMethods([
                'copyFile',
                'getFiles',
            ])
            ->getMock();

        $mockInstaller->method('copyFile')
            ->withAnyParameters()
            ->willThrowException((new InstallException()));

        $mockInstaller->method('getFiles')
            ->withAnyParameters()
            ->willReturn([
                'test' => [
                    'name' => 'Test',
                    'source' => __FILE__,
                    'destination' => __FILE__,
                ]
            ]);

        $this->mockService(InstallerService::class, function () use ($mockInstaller) {
            return $mockInstaller;
        });

        $this->exec('mixerapi install');
        $this->assertExitCode(1);
    }
}
