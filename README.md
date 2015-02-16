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

This command will:

1. Create a virtual host file named `serverName` or `vhost-filename` if set
2. Create an error log file named `vhost-filename.error.log` and an access log file named `vhost-filename.access.log` in the web server default logs directory
3. Enable the virtual host
4. Restart the web server

````bash

vhost-create dev.example.com /home/vagrant/sites/project/web

````

__Arguments__

| argument      | description                                         |
| ------------- | --------------------------------------------------- |
| serverName    | The server name of the virtual host                 |
| documentRoot  | The directory holding the front controller php file |

__Options__

| option                | default                        | description                    |
| --------------------- | ------------------------------ | ------------------------------ |
| --vhost-filename, -vf | {{serverName}}                 | The virtual host filename      |
| --env, -e             | dev                            | The environment of the project |


### vhost-delete ###

This command will:

1. Remove the virtual host file named `vhostFilename`
2. Remove both access and error log files from the web server default logs directory
3. Disable the virtual host
4. Restart the web server

````bash

vhost-delete dev.example.com

````

__Arguments__

| argument       | description               |
| -------------- | ------------------------- |
| vhostFilename  | The virtual host filename |


## TODO ##

+ Support more web servers
+ Improve tests
+ Vhost-list command

## License ##

[MIT](LICENSE)


## Authors ##

+ [Ignacio Velazquez](http://ignaciovelazquez.es)
