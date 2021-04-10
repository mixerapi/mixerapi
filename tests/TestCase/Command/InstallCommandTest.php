<?php

namespace MixerApi\Test\TestCase\Command;

use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

class InstallCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    private const ASSETS_DIR = ROOT . DS . 'plugins' . DS . 'mixerapi' . DS . 'assets' . DS;

    private const CONFIG_DIR = ROOT . DS . 'plugins' . DS . 'mixerapi' . DS . 'tests' . DS . 'installer_output' . DS . 'config' . DS;

    private const SRC_DIR = ROOT . DS . 'plugins' . DS . 'mixerapi' . DS . 'tests' . DS . 'installer_output' . DS . 'src' . DS;

    public function setUp(): void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApi\Test\App');
        $this->useCommandRunner();

        @unlink(self::CONFIG_DIR . 'swagger.yml');
        @unlink(self::CONFIG_DIR . 'swagger_bake.php');
        @unlink(self::CONFIG_DIR . 'routes.php');
        @unlink(self::CONFIG_DIR . 'app.php');
        @unlink(self::SRC_DIR . 'Controller' . DS . 'WelcomeController.php');
    }

    public function test_interactive_install()
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR,
            ['Y']
        );

        $this->filesExist();
    }

    public function test_auto_install()
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR .
            ' --auto Y'
        );

        $this->filesExist();
    }

    public function test_abort_interactive_install()
    {
        $this->exec(
            'mixerapi install' .
            ' --test_config_dir ' . self::CONFIG_DIR .
            ' --test_src_dir ' . self::SRC_DIR,
            ['N']
        );

        $this->assertExitError();
    }

    private function filesExist()
    {
        $this->assertFileExists(self::CONFIG_DIR . 'swagger.yml');
        $this->assertFileEquals(
            self::ASSETS_DIR . 'swagger.yml',
            self::CONFIG_DIR . 'swagger.yml'
        );

        $this->assertFileExists(self::CONFIG_DIR . 'swagger_bake.php');
        $this->assertFileEquals(
            self::ASSETS_DIR . 'swagger_bake.php',
            self::CONFIG_DIR . 'swagger_bake.php'
        );

        $this->assertFileExists(self::CONFIG_DIR . 'routes.php');
        $this->assertFileEquals(
            self::ASSETS_DIR . 'routes.php',
            self::CONFIG_DIR . 'routes.php'
        );

        $this->assertFileExists(self::CONFIG_DIR . 'app.php');
        $this->assertFileEquals(
            self::ASSETS_DIR . 'app.php',
            self::CONFIG_DIR . 'app.php'
        );

        $this->assertFileExists(self::SRC_DIR . 'Controller' . DS . 'WelcomeController.php');
        $this->assertFileEquals(
            self::ASSETS_DIR . 'WelcomeController.php',
            self::SRC_DIR . 'Controller' . DS . 'WelcomeController.php'
        );
    }
}
