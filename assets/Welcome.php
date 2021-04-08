<?php
declare(strict_types=1);

namespace App;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Composer\InstalledVersions;
use Exception;
use RuntimeException;

class Welcome
{
    /**
     * Returns an array of environment information
     *
     * @return array
     * @throws RuntimeException
     */
    public function info(): array
    {
        if (!version_compare(PHP_VERSION, '7.2.0', '>=')) {
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
            $connection = ConnectionManager::get('default');
            if (!$connection->connect()) {
                return 'unable to connect';
            }
        } catch (Exception $connectionError) {
            $errorMsg = $connectionError->getMessage();
            if (method_exists($connectionError, 'getAttributes')) :
                $attributes = $connectionError->getAttributes();
                if (isset($errorMsg['message'])) :
                    $errorMsg .= '. ' . $attributes['message'];
                endif;
            endif;
            return $errorMsg ?? 'unknown error / unable to connect';
        }

        return 'connected';
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
            'tmp' => is_writable(TMP),
            'logs' => is_writable(LOGS),
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
            ]
        ];
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    private function whichMixerApiVersion(): string
    {
        try {
            return InstalledVersions::getPrettyVersion('mixerapi/mixerapi');
        } catch (\Exception $e) {

        }

        try {
            return InstalledVersions::getPrettyVersion('mixerapi/mixerapi-dev');
        } catch (\Exception $e) {

        }

        throw new RuntimeException('Package mixerapi/mixerapi is not installed');
    }
}
