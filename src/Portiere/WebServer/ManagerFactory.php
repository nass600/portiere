<?php

namespace Portiere\WebServer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Class ManagerFactory
 *
 * The ManagerFactory creates a Manager instances of the currently running web server
 *
 * @package Portiere\WebServer
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class ManagerFactory
{
    /**
     * Creates a Manager depending on the running web server
     *
     * @return NginxManager
     */
    public static function create()
    {
        $fs = new Filesystem();
        $loader = new FilesystemLoader(__DIR__.'/../Resources/views/%name%');
        $templating = new PhpEngine(new TemplateNameParser(), $loader);

        return new NginxManager($fs, $templating);
    }
}
