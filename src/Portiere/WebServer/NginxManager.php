<?php

namespace Portiere\WebServer;

use Symfony\Component\Finder\Finder;

/**
 * Class NginxManager
 *
 * Manager handling Nginx web server actions
 *
 * @package Portiere\WebServer
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class NginxManager extends Manager
{
    /**
     * @var string Template filename
     */
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
     * Gets the full path of the available vhost file
     *
     * @param VhostInterface $vhost
     *
     * @return string
     */
    public function getVhostAvailablePath(VhostInterface $vhost)
    {
        return "{$this->config['sitesAvailablePath']}{$vhost->getFilename()}";
    }

    /**
     * Gets the full path of the enabled vhost file
     *
     * @param VhostInterface $vhost
     *
     * @return string
     */
    public function getVhostEnabledPath(VhostInterface $vhost)
    {
        return "{$this->config['sitesEnabledPath']}{$vhost->getFilename()}";
    }

    /**
     * Gets template for this web server
     *
     * @param VhostInterface $vhost
     *
     * @return false|string
     */
    public function getTemplate(VhostInterface $vhost)
    {
        return $this->templating->render(self::TEMPLATE_FILE, [
            'server' => $this->config,
            'vhost' => $vhost
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function createVhost(VhostInterface $vhost)
    {
        $template = $this->getTemplate($vhost);

        $this->fs->dumpFile($this->getVhostAvailablePath($vhost), $template);
        $this->enableVhost($vhost);
    }

    /**
     * {@inheritDoc}
     */
    protected function enableVhost(VhostInterface $vhost)
    {
        $this->fs->symlink(
            $this->getVhostAvailablePath($vhost),
            "{$this->config['sitesEnabledPath']}{$vhost->getFilename()}"
        );
    }

    /**
     * {@inheritDoc}
     */
    public function deleteVhost(VhostInterface $vhost)
    {
        foreach ($this->getGeneratedFiles($vhost) as $file) {
            $this->fs->remove($file);
        }
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
    public function getGeneratedFiles(VhostInterface $vhost)
    {
        return [
            $this->getVhostAvailablePath($vhost),
            $this->getVhostEnabledPath($vhost),
            "{$this->config['logsDir']}{$vhost->getErrorLogFilename()}",
            "{$this->config['logsDir']}{$vhost->getAccessLogFilename()}"
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
