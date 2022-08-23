<?php
declare(strict_types=1);

namespace MixerApi;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\Exception\MissingPluginException;
use Cake\Core\PluginApplicationInterface;
use MixerApi\Command\InstallCommand;
use MixerApi\Service\InstallerService;

class Plugin extends BasePlugin
{
    /**
     * Plugin name.
     *
     * @var string
     */
    protected $name = 'MixerApi';

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected $middlewareEnabled = false;

    /**
     * Load routes or not
     *
     * @var bool
     */
    protected $routesEnabled = false;

    /**
     * @inheritDoc
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $app->addPlugin('MixerApi/CollectionView');
        $app->addPlugin('MixerApi/ExceptionRender');
        $app->addPlugin('MixerApi/HalView');
        $app->addPlugin('MixerApi/JsonLdView');
        $app->addPlugin('MixerApi/Rest');
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
     * @inheritDoc
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        $commands->add('mixerapi install', InstallCommand::class);

        return $commands;
    }

    /**
     * @inheritDoc
     */
    public function services(ContainerInterface $container): void
    {
        if (PHP_SAPI === 'cli') {
            $container
                ->add(InstallerService::class);

            $container
                ->add(InstallCommand::class)
                ->addArgument(InstallerService::class);
        }
    }
}
