<?php

namespace Portiere\WebServer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Class Manager
 *
 * @package Portiere\WebServer
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
abstract class Manager
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * @var \Symfony\Component\Templating\PhpEngine
     */
    protected $templating;

    /**
     * @var Vhost
     */
    protected $vhost;

    /**
     * @param Vhost|null $vhost
     */
    public function __construct(Vhost $vhost = null)
    {
        $this->vhost = $vhost;
        $this->fs = new Filesystem();

        $loader = new FilesystemLoader(__DIR__.'/../Resources/views/%name%');
        $this->templating = new PhpEngine(new TemplateNameParser(), $loader);
    }

    /**
     * Creates the virtual host related files
     *
     * @return $this
     */
    abstract public function createVhost();

    /**
     * Enables the virtual host
     *
     * @return $this
     */
    abstract protected function enableVhost();

    /**
     * Deletes all virtual host associated files
     *
     * @return $this
     */
    abstract public function deleteVhost();

    /**
     * Lists current virtual hosts
     *
     * @return array [vhost name, enabled]
     */
    abstract public function listVhosts();

    /**
     * Gets the generated files for a virtual host
     *
     * @return array
     */
    abstract public function getGeneratedFiles();

    /**
     * Restarts web server
     *
     * @return $this
     */
    abstract public function restartServer();
}
