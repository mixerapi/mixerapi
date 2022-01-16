<?php
declare(strict_types=1);

namespace MixerApi;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Composer\InstalledVersions;
use Exception;
use RuntimeException;

class Welcome
{
    public const DATABASE_CONNECTED_MSG = 'connected';

    /**
     * @param string|null $phpVersion the php version, defaults to PHP_VERSION
     * @param \Cake\Database\Connection|null $connection CakePHP db connection
     */
    public function __construct(private ?string $phpVersion = PHP_VERSION, private ?Connection $connection = null)
    {
        $this->phpVersion = $this->phpVersion ?? PHP_VERSION;

        if ($this->connection == null && ConnectionManager::get('default') instanceof Connection) {
            $this->connection = ConnectionManager::get('default');
        }
    }

    /**
     * Returns an array of environment information
     *
     * @return array
     * @throws \RuntimeException
     */
    public function info(): array
    {
        if (!version_compare($this->phpVersion, '7.2.0', '>=')) {
            throw new RuntimeException(
                'Your version of PHP is too low. You need PHP 7.2.0 or higher to use CakePHP ' .
                '(detected `' . PHP_VERSION . '`)'
            );
        }

        return [
            'mixerapi_version' => $this->whichMixerApiVersion(),
            'cakephp_version' => Configure::version() . ' Strawberry (🍓)',
            'database' => $this->database(),
            'environment' => $this->environment(),
            'filesystem' => $this->filesystem(),
            'mixerapi' => $this->mixerapi(),
            'cakephp' => $this->cakephp(),
        ];
    }

    /**
     * @return string
     */
    private function database()
    {
        try {
            if (!$this->connection->connect()) {
                return 'unable to connect';
            }
        } catch (Exception $connectionError) {
            $errorMsg = $connectionError->getMessage();
            if (method_exists($connectionError, 'getAttributes')) {
                $attributes = $connectionError->getAttributes();
                $errorMsg .= $attributes['message'] ?? '';
            }

            return $errorMsg ?? 'unknown error / unable to connect';
        }

        return self::DATABASE_CONNECTED_MSG;
    }

    /**
     * @return array
     */
    private function environment(): array
    {
        return [
            'php' => PHP_VERSION,
            'mbstring' => extension_loaded('mbstring'),
            'openssl' => extension_loaded('openssl'),
            'mcrypt' => extension_loaded('mcrypt'),
            'intl' => extension_loaded('intl'),
        ];
    }

    /**
     * @return array
     */
    private function filesystem(): array
    {
        return [
            'tmp' => defined('TMP') ? is_writable(TMP) : false,
            'logs' => defined('LOGS') ? is_writable(LOGS) : false,
            'cache' => !empty(Cache::getConfig('_cake_core_')),
        ];
    }

    /**
     * @return array
     */
    private function mixerapi(): array
    {
        return [
            'loaded' => Plugin::isLoaded('MixerApi'),
            'home' => 'https://mixerapi.com',
            'github' => 'https://github.com/mixerapi',
        ];
    }

    /**
     * @return array
     */
    private function cakephp(): array
    {
        return [
            'documentation' => 'https://book.cakephp.org/4/en/',
            'support' => [
                'irc' => 'irc://irc.freenode.net/cakephp',
                'slack' => 'http://cakesf.herokuapp.com/',
                'issues' => 'https://github.com/cakephp/cakephp/issues',
                'forum' => 'http://discourse.cakephp.org/',
            ],
            'docs' => [
                'cakephpapi' => 'https://api.cakephp.org/',
                'bakery' => 'https://bakery.cakephp.org',
                'github' => 'https://github.com/cakephp/',
                'awesome' => 'https://github.com/FriendsOfCake/awesome-cakephp',
                'cakephp' => 'https://www.cakephp.org',
            ],
        ];
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    private function whichMixerApiVersion(): string
    {
        try {
            return InstalledVersions::getPrettyVersion('mixerapi/mixerapi');
        } catch (\Exception $e) {
            try {
                return InstalledVersions::getPrettyVersion('mixerapi/mixerapi-dev');
            // the following should not be possible:
            // @codeCoverageIgnoreStart
            } catch (\Exception $e) {
                throw new RuntimeException('Package mixerapi/mixerapi is not installed');
            }
            // @codeCoverageIgnoreEnd
        }
    }
}
