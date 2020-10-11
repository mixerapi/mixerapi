<?php

namespace MixerApi\Test\TestCase;

use Cake\Core\Plugin;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use TestApp\Application;

class PluginTest extends TestCase
{
    use IntegrationTestTrait;

    public function setUp(): void
    {
        parent::setUp();
        static::setAppNamespace();
    }

    public function testBootstrap()
    {
        $plugin = new \MixerApi\Plugin();
        $plugin->bootstrap(new Application(CONFIG));

        $plugins = [
            'MixerApi/Bake',
            'MixerApi/CollectionView',
            'MixerApi/ExceptionRender',
            'MixerApi/HalView',
            'MixerApi/JsonLdView',
            'MixerApi/Rest',
            'SwaggerBake',
            'Search',
        ];

        $loadedPlugins = Plugin::loaded();

        foreach ($plugins as $plugin) {
            $this->assertTrue(in_array($plugin, $loadedPlugins), "$plugin not loaded");
        }
    }
}