<?php

namespace Portiere\WebServer;

use Symfony\Component\Finder\Finder;

/**
 * Class NginxManager
 *
 * @package Portiere\WebServer
 */
class NginxManager extends Manager
{
    const TEMPLATE_FILE = 'nginx.php';

    /**
     * @var array
     */
    protected $config = [
        'sitesAvailablePath' => '/etc/nginx/sites-available/',
        'sitesEnabledPath' => '/etc/nginx/sites-enabled/',
        'logsDir' => '/var/log/nginx/'
    ];

    /**
     * @return string
     */
    public function getVhostAvailablePath()
    {
        return "{$this->config['sitesAvailablePath']}{$this->vhost->getFilename()}";
    }

    /**
     * @return string
     */
    public function getVhostEnabledPath()
    {
        return "{$this->config['sitesEnabledPath']}{$this->vhost->getFilename()}";
    }

    /**
     * Gets template for this web server
     *
     * @return false|string
     */
    public function getTemplate()
    {
        return $this->templating->render(self::TEMPLATE_FILE, [
            'server' => $this->config,
            'vhost' => $this->vhost
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function createVhost()
    {
        $template = $this->getTemplate();

        $this->fs->dumpFile($this->getVhostAvailablePath(), $template);
        $this->enableVhost();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    protected function enableVhost()
    {
        $this->fs->symlink($this->getVhostAvailablePath(), $this->getVhostEnabledPath());

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteVhost()
    {
        foreach ($this->getGeneratedFiles() as $file) {
            $this->fs->remove($file);
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function listVhosts()
    {
        $finder = new Finder();
        $enabled = $vhosts = [];
        foreach ($finder->files()->in($this->config['sitesEnabledPath']) as $file) {
            $enabled[] = $file->getFilename();
        }

        $finder = new Finder();
        foreach ($finder->files()->in($this->config['sitesAvailablePath']) as $file) {
            $vhosts[] = [$file->getFilename(), in_array($file->getFilename(), $enabled)];
        }

        return $vhosts;
    }

    /**
     * {@inheritDoc}
     */
    public function getGeneratedFiles()
    {
        return [
            $this->getVhostAvailablePath(),
            $this->getVhostEnabledPath(),
            "{$this->config['logsDir']}{$this->vhost->getErrorLogFilename()}",
            "{$this->config['logsDir']}{$this->vhost->getAccessLogFilename()}"
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function restartServer()
    {
        shell_exec("service nginx restart");
    }
}
