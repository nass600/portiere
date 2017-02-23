<?php

namespace VhostBuilder\Builder;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Class Builder
 *
 * @package VhostBuilder\Builder
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
abstract class Builder
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
     * @param Vhost $vhost
     */
    public function __construct(Vhost $vhost)
    {
        $this->vhost = $vhost;
        $this->fs = new Filesystem();

        $loader = new FilesystemLoader(__DIR__.'/../Resources/views/%name%');
        $this->templating = new PhpEngine(new TemplateNameParser(), $loader);
    }

    abstract public function createVhost();

    abstract public function deleteVhost();

    abstract public function getGeneratedFiles();

    abstract public function restartServer();
}
