<?php

namespace MixerApi\Test\TestCase;

use Cake\Core\Plugin;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use MixerApi\Test\App\Application;

class PluginTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace('MixerApi\Test\App');
    }

    public function test_bootstrap(): void
    {
        $plugin = new \MixerApi\Plugin();
        $plugin->bootstrap(new Application(CONFIG));

        $plugins = [
            'MixerApi/Bake',
            'MixerApi/CollectionView',
            'MixerApi/ExceptionRender',
            'MixerApi/HalView',
            'MixerApi/JsonLdView',
            'SwaggerBake',
            'Search',
        ];

        $loadedPlugins = Plugin::loaded();

        foreach ($plugins as $plugin) {
            $this->assertTrue(in_array($plugin, $loadedPlugins), "$plugin not loaded");
        }
    }
}
