<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerApi" src="mixer-api-200x-178x.png" />
  </a>
</p>
<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://travis-ci.org/mixerapi/mixerapi" target="_blank">
        <img alt="Build Status" src="https://travis-ci.org/mixerapi/mixerapi.svg?branch=master">
    </a>
    <a href="https://coveralls.io/repos/github/mixerapi/mixerapi/badge.svg?branch=master" target="_blank">
        <img alt="Coverage Status" src="https://img.shields.io/coveralls/cakephp/cakephp/master.svg?style=flat-square">
    </a>
    <a href="https://packagist.org/packages/mixerapi/mixerapi" target="_blank">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/mixerapi/mixerapi.svg?style=flat-square">
    </a>
    <a href="https://book.cakephp.org/4/en/index.html">
        <img alt="CakePHP >= 4" src="https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp">
    </a>
    <a href="https://php.net/" target="_blank">
        <img alt="PHP >= 7.2" src="https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php">
    </a>
</p>

*Note: This is an alpha stage plugin*

Streamline development of API-first applications in CakePHP

## Installation 

```bash
composer require mixerapi/mixerapi
bin/cake plugin load MixerApi
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi');
}
```

## Features

MixerAPI automatically installs the following plugins for your RESTful API project:

### :cook: [Bake](https://github.com/mixerapi/bake)

Create RESTful CakePHP controllers in seconds with an API focused bake template.

### :rocket: [Rest](https://github.com/mixerapi/rest)

Gets your API project up and going quickly by creating routes for you. It can either:

- Build your routes.php file from a single command, or
- Automatically expose RESTful CRUD routes with a handy middleware.

### :battery: [SwaggerBake](https://github.com/cnizzardini/cakephp-swagger-bake)

A delightfully tasty tool for generating Swagger documentation with OpenApi 3.0.0 schema. This plugin automatically 
builds your Swagger UI and ReDoc from your existing cake models and routes.

### :newspaper_roll: [HalView](https://github.com/mixerapi/hal-view)

A Hypertext Application Language ([HAL+JSON](http://stateless.co/hal_specification.html)) View for CakePHP. This plugin 
supports links, pagination, and embedded resources. Once setup any request with application/hal+json will be rendered 
by this plugin.

## Unit Tests

```bash
vendor/bin/phpunit
```

## Code Standards

```bash
composer check
```