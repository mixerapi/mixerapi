<?php

namespace MixerApi\Test\TestCase\Console;

use Composer\Config;
use Composer\IO\IOInterface;

class Io implements IOInterface
{
    private $interactive;

    public function __construct(bool $interactive)
    {
        $this->interactive = $interactive;
    }

    public function isInteractive()
    {
        return $this->interactive;
    }

    public function isVerbose()
    {
        // TODO: Implement isVerbose() method.
    }

    public function isVeryVerbose()
    {
        // TODO: Implement isVeryVerbose() method.
    }

    public function isDebug()
    {
        // TODO: Implement isDebug() method.
    }

    public function isDecorated()
    {
        // TODO: Implement isDecorated() method.
    }

    public function write($messages, $newline = true, $verbosity = self::NORMAL)
    {
        // TODO: Implement write() method.
    }

    public function writeError($messages, $newline = true, $verbosity = self::NORMAL)
    {
        // TODO: Implement writeError() method.
    }

    public function writeRaw($messages, $newline = true, $verbosity = self::NORMAL)
    {
        // TODO: Implement writeRaw() method.
    }

    public function writeErrorRaw($messages, $newline = true, $verbosity = self::NORMAL)
    {
        // TODO: Implement writeErrorRaw() method.
    }

    public function overwrite($messages, $newline = true, $size = null, $verbosity = self::NORMAL)
    {
        // TODO: Implement overwrite() method.
    }

    public function overwriteError($messages, $newline = true, $size = null, $verbosity = self::NORMAL)
    {
        // TODO: Implement overwriteError() method.
    }

    public function ask($question, $default = null)
    {
        // TODO: Implement ask() method.
    }

    public function askConfirmation($question, $default = true)
    {
        // TODO: Implement askConfirmation() method.
    }

    public function askAndValidate($question, $validator, $attempts = null, $default = null)
    {
        // TODO: Implement askAndValidate() method.
    }

    public function askAndHideAnswer($question)
    {
        // TODO: Implement askAndHideAnswer() method.
    }

    public function select($question, $choices, $default, $attempts = false, $errorMessage = 'Value "%s" is invalid', $multiselect = false)
    {
        // TODO: Implement select() method.
    }

    public function getAuthentications()
    {
        // TODO: Implement getAuthentications() method.
    }

    public function hasAuthentication($repositoryName)
    {
        // TODO: Implement hasAuthentication() method.
    }

    public function getAuthentication($repositoryName)
    {
        // TODO: Implement getAuthentication() method.
    }

    public function setAuthentication($repositoryName, $username, $password = null)
    {
        // TODO: Implement setAuthentication() method.
    }

    public function loadConfiguration(Config $config)
    {
        // TODO: Implement loadConfiguration() method.
    }

    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }

    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }

    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }

    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }

    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }

    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }

    public function info($message, array $context = array())
    {
        // TODO: Implement info() method.
    }

    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }

    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}
