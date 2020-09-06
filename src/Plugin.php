<?php
declare(strict_types=1);

namespace MixerApi;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

class Plugin extends BasePlugin
{
    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $app->addPlugin('MixerApi/Rest');
        $app->addPlugin('MixerApi/HalView');
        $app->addPlugin('MixerApi/JsonLdView');
        $app->addPlugin('MixerApi/ExceptionRender');
        $app->addPlugin('SwaggerBake');

        if (PHP_SAPI === 'cli') {
            $app->addPlugin('MixerApi/Bake');
        }

        parent::bootstrap($app);
    }
}
