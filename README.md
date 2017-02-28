<h1 align="center">
    <img src="docs/img/portiere.png" alt="Portiere - Virtual host builder" width="200" height="156">
    <br>
    Portiere
    <br>
    <br>
</h1>

<p align="center">
    <a href="https://travis-ci.org/nass600/portiere">
        <img src="https://api.travis-ci.org/nass600/portiere.svg?branch=master" alt="Travis Build Status"/>
    </a>
    <a href="https://packagist.org/packages/nass600/portiere">
        <img src="https://img.shields.io/packagist/v/nass600/portiere.svg" alt="Packagist Latest Version"/>
    </a>
    <a href="https://packagist.org/packages/nass600/portiere">
        <img src="https://img.shields.io/packagist/dt/nass600/portiere.svg" alt="Packagist Download Counter"/>
    </a>
    <a href="LICENSE">
        <img src="https://img.shields.io/packagist/l/nass600/portiere.svg" alt="License"/>
    </a>
    <a href="https://insight.sensiolabs.com/projects/9e74d5de-38cd-498b-b2dc-cc834479406f">
        <img src="https://insight.sensiolabs.com/projects/9e74d5de-38cd-498b-b2dc-cc834479406f/mini.png" alt="SensioLabs Insight"/>
    </a>

</p>

<h4 align="center">
    Symfony Console command to handle virtual hosts for a Symfony project in a Unix machine.
</h4>

## Supported Web Servers


| ![](docs/img/nginx.png)  |
|:------------------------:|
| Nginx                    |


## Installation

The installation is handled by composer and you can install it either globally or locally.

### Globally

Require the library globally by executing:

````bash
composer global require nass600/portiere 0.4.0
````

and add composer global package binaries to your PATH if you didn't yet:

````bash
echo "export PATH=~/.composer/vendor/bin:$PATH" >> ~/.bashrc
````

You are ready to go by running wherever you want the commands `vhost-create`and `vhost-delete`

### Locally

Require the library by executing:

````bash
composer require-dev nass600/portiere 0.4.0
````

You are ready to go by running from the root of your project the commands `bin/vhost-create`and `bin/vhost-delete`


## Usage

**Note**: You probably need `sudo` permissions for executing this commands successfully

### vhost:list

Lists all the virtual hosts

````bash
portiere vhost:list
````

### vhost:create

This command will:

1. Create a virtual host file named `serverName` or `vhost-filename` if set
2. Create an error log file named `vhost-filename.error.log` and an access log file named `vhost-filename.access.log` in the web server default logs directory
3. Enable the virtual host
4. Restart the web server

````bash
portiere vhost:create dev.example.com /home/user/sites/project/web
````

__Arguments__

| argument      | description                                         |
| ------------- | --------------------------------------------------- |
| serverName    | The server name of the virtual host                 |
| documentRoot  | The directory holding the front controller php file |

__Options__

| option                | default        | description                                     |
| --------------------- | -------------- | ----------------------------------------------- |
| --vhost-filename, -vf | {{serverName}} | The virtual host filename                       |
| --no-dev              |                | Don't add development environment to vhost file |


### vhost:delete

This command will:

1. Remove the virtual host file named `vhostFilename`
2. Remove both access and error log files from the web server default logs directory
3. Disable the virtual host
4. Restart the web server

````bash
portiere vhost:delete dev.example.com
````

__Arguments__

| argument       | description               |
| -------------- | ------------------------- |
| vhostFilename  | The virtual host filename |


## Future work

+ Support more web servers
+ Improve tests

## License

[MIT](LICENSE)

## Authors

+ [Ignacio Velazquez](http://ignaciovelazquez.es)
