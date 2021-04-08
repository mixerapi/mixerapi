<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use MixerApi\Rest\Lib\AutoRouter;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {

    /**
     * CakePHP default welcome page route:
     */
    //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    //$builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    //$builder->fallbacks();

    // Parse specified extensions from URLs
    $builder->setExtensions(['json', 'xml']);

    /**
     * Welcome route
     * @todo you can delete this
     */
    $builder->resources('Welcome', [
        'only' => ['info'],
        'map' => [
            'info' => [
                'action' => 'info',
                'method' => 'GET',
            ]
        ]
    ]);

    /**
     * Automatically expose RESTful CRUD routes with a handy AutoRouter.
     * @see https://github.com/mixerapi/rest
     */
    (new AutoRouter($builder))->buildResources();

    /*
     * Here, we are connecting '/' (base path) to a SwaggerBake
     * @see https://github.com/cnizzardini/cakephp-swagger-bake
     */
    $builder->connect('/', ['plugin' => 'SwaggerBake', 'controller' => 'Swagger', 'action' => 'index']);

    /**
     * JSON-LD routes
     * @see https://github.com/mixerapi/json-ld-view
     */
    $builder->connect('/contexts/*', [
        'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
    ]);
    $builder->connect('/vocab', [
        'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
    ]);

    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *
 *     // Connect API actions here.
 * });
 * ```
 */
