<?php

namespace Portiere\WebServer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class Manager.
 *
 * The Manager handles every web server possible action
 *
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
     * Manager constructor.
     *
     * @param Filesystem      $fs
     * @param EngineInterface $templating
     */
    public function __construct(Filesystem $fs, EngineInterface $templating)
    {
        $this->fs = $fs;
        $this->templating = $templating;
    }

    /**
     * Creates the virtual host related files.
     *
     * @param VhostInterface $vhost
     */
    abstract public function createVhost(VhostInterface $vhost);

    /**
     * Enables the virtual host.
     *
     * @param VhostInterface $vhost
     */
    abstract protected function enableVhost(VhostInterface $vhost);

    /**
     * Deletes all virtual host associated files.
     *
     * @param VhostInterface $vhost
     */
    abstract public function deleteVhost(VhostInterface $vhost);

    /**
     * Lists current virtual hosts.
     *
     * @return array [vhost name, enabled]
     */
    abstract public function listVhosts();

    /**
     * Gets the generated files for a virtual host.
     *
     * @param VhostInterface $vhost
     *
     * @return array
     */
    abstract public function getGeneratedFiles(VhostInterface $vhost);

    /**
     * Restarts web server.
     */
    abstract public function restartServer();
}
