![Logo](./assets/mixerapi.svg#gh-light-mode-only)

<p align="center">
    A CakePHP Plugin for RESTful API Development
</p>
<p align="center">
    <a href="https://packagist.org/packages/mixerapi/mixerapi" target="_blank">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/mixerapi/mixerapi.svg?style=flat-square">
    </a>
    <a href="https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild" target="_blank">
        <img alt="Build Status" src="https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master">
    </a>
    <a href="https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master" target="_blank">
        <img alt="Coverage Status" src="https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master">
    </a>
    <a href="https://book.cakephp.org/4/en/index.html">
        <img alt="CakePHP ^4.2" src="https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp">
    </a>
    <a href="https://php.net/" target="_blank">
        <img alt="PHP ^8.0" src="https://img.shields.io/badge/php-^8.0-8892BF.svg?logo=php">
    </a>
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
</p>

Streamline development of modern RESTful APIs for your teams CakePHP project. Designed around a component-based
architecture, MixerAPI enables developers to pick and choose the functionality they need for developing REST APIs.

[Documentation](https://mixerapi.com) |
[Demo Application](https://demo.mixerapi.com) |
[Demo Source Code](https://github.com/mixerapi/demo)

## Features

- **Rapid Prototyping:** Scaffold your API in seconds with a custom Bake template geared towards modern REST architecture.
- **OpenAPI:** Automatically generates [OpenAPI](https://www.openapis.org/) from your existing code into
  [Swagger](https://swagger.io/) and [Redoc](https://redoc.ly/). Attributes provided, but not required.
- **Error Handling:** Handles exception rendering in XML or JSON.
- **Data Formats:** Formats responses in JSON, XML, HAL+JSON, or JSON-LD.
- **Integrations:** Integrates well with other CakePHP 4 compatible plugins.
- **Minimalist Configuration:** Built for developing, not writing YAML configurations. Most components require zero
  configuration files.
- **Non-opinionated:** Develop your way.


This is a read-only repository. Please submit issues and PRs to
[mixerapi/mixerapi-dev](https://github.com/mixerapi/mixerapi-dev)

For install steps head over to [https://mixerapi.com/install](https://mixerapi.com/install)

## MixerAPI Core Plugins

MixerAPI automatically installs the following plugins for your RESTful API project:

| Plugin | Description |
| ------------- | ------------- |
| [MixerApi/Bake](https://github.com/mixerapi/bake) | A custom bake template focused on creating RESTful CakePHP controllers in seconds |
| [MixerApi/CollectionView](https://github.com/mixerapi/collection-view) | A Collection View for displaying configurable pagination meta-data in JSON or XML collection responses |
| [MixerApi/ExceptionRender](https://github.com/mixerapi/exception-render) | Handles rendering entity validation errors and other exceptions for your API |
| [MixerApi/HalView](https://github.com/mixerapi/hal-view) | A Hypertext Application Language ([HAL+JSON](http://stateless.co/hal_specification.html)) View for CakePHP |
| [MixerApi/JsonLdView](https://github.com/mixerapi/json-ld-view) | A [JSON-LD](https://json-ld.org/) View for CakePHP |
| [MixerApi/Rest](https://github.com/mixerapi/rest) | Gets your API project up and going quickly by creating routes for you |
| [SwaggerBake](https://github.com/cnizzardini/cakephp-swagger-bake) | A delightfully tasty tool for generating Swagger documentation with OpenApi 3.0.0 schema |

## Recommended Plugins

| Plugin | Description |
| ------------- | ------------- |
| [MixerApi/Crud](https://github.com/mixerapi/crud) | A service provider for CRUD (Create/Read/Update/Delete) operations. Since this plugin uses the experimental CakePHP dependency injection it must be enabled separately. |
| [Search](https://github.com/FriendsOfCake/search) | Search provides a simple interface to create paginate-able filters for your CakePHP application. |
