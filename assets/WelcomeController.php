<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use App\Welcome;
use SwaggerBake\Lib\Annotation as Swag;

class WelcomeController extends AppController
{
    /**
     * Welcome to MixerAPI
     *
     * Welcome to MixerAPI. This endpoint will return information on your environment, cakephp, and mixerapi.
     *
     * You can modify or delete this endpoint in `config/routes.php`
     *
     * You can modify or delete this controller in `src/Controller/WelcomeController.php`
     *
     * You can see the sample schema in `config/swagger.yml` > `#/components/schemas/Welcome`
     *
     * @Swag\SwagResponseSchema(refEntity="#/components/schemas/Welcome")
     * @see https://mixerapi.com
     * @return \Cake\Http\Response|null|void Renders view
     * @return \RuntimeException if PHP version is < 7.2
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function info()
    {
        $this->request->allowMethod('get');

        $info = (new Welcome())->info();

        $this->set(compact('info'));
        $this->viewBuilder()->setOption('serialize', 'info');
    }
}
