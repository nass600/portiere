# Vhost Builder #

Symfony2 Console command to handle virtual hosts creation and deletion for a Symfony project in a Unix machine.

It is designed for development environments, do not use it in production.

__Warning!! This is a work in progress__

[![Build Status](https://api.travis-ci.org/nass600/vhost-builder.svg?branch=master)](https://travis-ci.org/nass600/vhost-builder)
[![Latest Stable Version](https://poser.pugx.org/nass600/vhost-builder/v/stable.png)](https://packagist.org/packages/nass600/vhost-builder)
[![Total Downloads](https://poser.pugx.org/nass600/vhost-builder/downloads.png)](https://packagist.org/packages/nass600/vhost-builder)
[![License](https://poser.pugx.org/nass600/vhost-builder/license.svg)](https://packagist.org/packages/nass600/vhost-builder)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/2d92548d-2c86-4677-87de-0ec33c1670bb/mini.png)](https://insight.sensiolabs.com/projects/2d92548d-2c86-4677-87de-0ec33c1670bb)

## Supported Web Servers ##

Right now the following web servers are supported:

+ [Nginx](http://nginx.org/)


## Installation ##

The installation is handled by composer and you can install it either globally or locally.

### Globally ###

Require the library globally by executing:

````bash

composer global require nass600/vhost-builder *

````

and add composer global package binaries to your PATH if you didn't yet:

````bash

echo "export PATH=~/.composer/vendor/bin:$PATH" >> ~/.bashrc

````

You are ready to go by running wherever you want the commands `vhost-create`and `vhost-delete`

### Locally ###

Require the library by executing:

````bash

composer require-dev nass600/vhost-builder *

````

You are ready to go by running from the root of your project the commands `bin/vhost-create`and `bin/vhost-delete`


## Usage ##

### vhost-create ###

This command will create and enable a virtual host. After the creation the web server is restarted.

````bash

vhost-create dev.example.com /home/vagrant/sites/project/web

````

__Parameters__

| parameter     | description                                         |
| ------------- | --------------------------------------------------- |
| server-name   | The server name of the virtual host                 |
| document-root | The directory holding the front controller php file |

__Options__

| option                | default                    | description                    |
| --------------------- | -------------------------- | ------------------------------ |
| --vhost-filename, -vf | {{server-name}}            | The virtual host filename      |
| --error-logifle, -el  | {{server-name}}.error.log  | The error log filename         |
| --access-logifle, -el | {{server-name}}.access.log | The access log filename        |
| --env, -e             | dev                        | The environment of the project |


### vhost-delete ###

This command will remove and disable a virtual host. After the deletion the web server is restarted

````bash

vhost-create dev.example.com

````

__Parameters__

| parameter      | description               |
| -------------- | ------------------------- |
| vhost-filename | The virtual host filename |


## TODO ##

+ Support more web servers
+ Improve tests

## License ##

[MIT](LICENSE)


## Authors ##

+ [Ignacio Velazquez](http://ignaciovelazquez.es)
