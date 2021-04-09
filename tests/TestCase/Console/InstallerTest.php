<?php

namespace MixerApi\Test\TestCase\Console;

use Cake\TestSuite\TestCase;
use Composer\Script\Event;
use MixerApi\Console\Installer;

class InstallerTest extends TestCase
{
    private $event;

    private $tests;

    private $assets;

    private $configDir;

    private $srcDir;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->tests = dirname(__FILE__) . DS . '..' . DS . '..' . DS;
        $this->assets = dirname(__FILE__) . DS . '..' . DS . '..' . DS . '..' . DS . 'assets' . DS;
        $this->configDir = $this->tests . 'installer_output' . DS . 'config' . DS;
        $this->srcDir = $this->tests . 'installer_output' . DS . 'src'. DS;
    }

    public function setUp(): void
    {
        $this->event = $this->createPartialMock(Event::class, [
            'getIO'
        ]);
    }

    public function test_interactive_post_install()
    {
        @unlink($this->configDir . 'swagger.yml');
        @unlink($this->configDir . 'swagger_bake.php');
        @unlink($this->configDir . 'routes.php');
        @unlink($this->configDir . 'app.php');
        @unlink($this->srcDir . 'Controller' . DS . 'WelcomeController.php');
        @unlink($this->srcDir . 'Welcome.php');
        @unlink($this->srcDir . 'Application.php');

        $this->event
            ->expects($this->once())
            ->method('getIo')->willReturn(new Io(true));

        $this->assertTrue(Installer::postInstall($this->event, true));

        $this->assertFileExists($this->configDir . 'swagger.yml');
        $this->assertFileEquals(
            $this->assets . 'swagger.yml',
            $this->configDir . 'swagger.yml'
        );

        $this->assertFileExists($this->configDir . 'swagger_bake.php');
        $this->assertFileEquals(
            $this->assets . 'swagger_bake.php',
            $this->configDir . 'swagger_bake.php'
        );

        $this->assertFileExists($this->configDir . 'routes.php');
        $this->assertFileEquals(
            $this->assets . 'routes.php',
            $this->configDir . 'routes.php'
        );

        $this->assertFileExists($this->configDir . 'app.php');
        $this->assertFileEquals(
            $this->assets . 'app.php',
            $this->configDir . 'app.php'
        );

        $this->assertFileExists($this->srcDir . 'Controller' . DS . 'WelcomeController.php');
        $this->assertFileEquals(
            $this->assets . 'WelcomeController.php',
            $this->srcDir . 'Controller' . DS . 'WelcomeController.php'
        );

        $this->assertFileExists($this->srcDir. 'Welcome.php');
        $this->assertFileEquals(
            $this->assets . 'Welcome.php',
            $this->srcDir . 'Welcome.php'
        );

        $this->assertFileExists($this->srcDir . 'Application.php');
        $this->assertFileEquals(
            $this->assets . 'Application.php',
            $this->srcDir . 'Application.php'
        );
    }

    public function test_non_interactive_post_install()
    {
        $this->event
            ->expects($this->once())
            ->method('getIo')->willReturn(new Io(false));

        $this->assertEquals(null, Installer::postInstall($this->event, true));
    }
}
