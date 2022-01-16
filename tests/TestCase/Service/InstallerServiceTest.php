<?php

namespace MixerApi\Test\TestCase\Service;

use Cake\TestSuite\TestCase;
use MixerApi\Exception\InstallException;
use MixerApi\Service\InstallerService;

class InstallerServiceTest extends TestCase
{
    public function test_copy_file_throws_install_exception_because_source_file_missing(): void
    {
        $file = '/tmp/' . md5((string)microtime(true));
        $this->expectException(InstallException::class);
        $this->expectExceptionMessage(
            sprintf(InstallException::SOURCE_FILE_MISSING, $file)
        );
        (new InstallerService())->copyFile(['source' => $file]);
    }

    public function test_copy_file_throws_install_exception_because_destination_file_exists_already(): void
    {
        $this->expectException(InstallException::class);
        $this->expectExceptionMessage(
            sprintf(InstallException::DESTINATION_FILE_EXISTS, 'Test Name', __FILE__)
        );
        (new InstallerService())->copyFile(['destination' => __FILE__, 'name' => 'Test Name', 'source' => __FILE__]);
    }

    public function test_copy_throws_install_exception(): void
    {
        $this->expectException(InstallException::class);
        (new InstallerService())->copy(['source' => __FILE__, 'destination' => 'dev/null']);
    }
}
