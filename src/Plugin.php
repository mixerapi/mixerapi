<?php
declare(strict_types=1);

namespace MixerApi;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Command\InstallCommand;

class Plugin extends BasePlugin
{
    /**
     * @param \Cake\Core\PluginApplicationInterface $app PluginApplicationInterface
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $app->addPlugin('MixerApi/CollectionView');
        $app->addPlugin('MixerApi/ExceptionRender');
        $app->addPlugin('MixerApi/HalView');
        $app->addPlugin('MixerApi/JsonLdView');
        $app->addPlugin('MixerApi/Rest');
        $app->addPlugin('Search');
        $app->addPlugin('SwaggerBake');

        if (PHP_SAPI === 'cli') {
            try {
                $app->addPlugin('MixerApi/Bake');
            // @codeCoverageIgnoreStart
            } catch (MissingPluginException $e) {
                // Do not halt if the plugin is missing
            }
            // @codeCoverageIgnoreEnd
        }

        parent::bootstrap($app);
    }

    /**
     * @param \Cake\Console\CommandCollection $commands CommandCollection
     * @return \Cake\Console\CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('mixerapi install', InstallCommand::class);

        return $commands;
    }
}
