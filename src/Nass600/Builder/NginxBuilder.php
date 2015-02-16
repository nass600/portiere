<?php

namespace Nass600\Builder;

class NginxBuilder extends Builder
{
    const TEMPLATE_FILE = 'nginx.php';

    /**
     * @var array
     */
    protected $config = [
        'sitesAvailablePath' => '/etc/nginx/sites-available/',
        'sitesEnabledPath'   => '/etc/nginx/sites-enabled/',
        'logsDir'            => '/var/log/nginx/',
        'hostsFilePath'      => '/etc/hosts'
    ];

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return false|string
     */
    public function getTemplate()
    {
        return $this->templating->render(
            self::TEMPLATE_FILE, [
                'server' => $this->config,
                'vhost'  => $this->vhost
            ]
        );
    }

    public function getVhostAvailablePath()
    {
        return "{$this->config['sitesAvailablePath']}{$this->vhost->getFilename()}";
    }

    public function getVhostEnabledPath()
    {
        return "{$this->config['sitesEnabledPath']}{$this->vhost->getFilename()}";
    }

    public function getErrorLogPath()
    {
        return "{$this->config['logsDir']}{$this->vhost->getErrorLogFilename()}";
    }

    public function getAccessLogPath()
    {
        return "{$this->config['logsDir']}{$this->vhost->getAccessLogFilename()}";
    }

    public function createVhost()
    {
        $template = $this->getTemplate();

        $this->fs->dumpFile($this->getVhostAvailablePath(), $template);
        $this->fs->symlink($this->getVhostAvailablePath(), $this->getVhostEnabledPath());

        return $this;
    }

    public function deleteVhost()
    {
        foreach ($this->getGeneratedFiles() as $file) {
            $this->fs->remove($file);
        }

        return $this;
    }

    public function getGeneratedFiles()
    {
        return [
            $this->getVhostAvailablePath(),
            $this->getVhostEnabledPath(),
            $this->getErrorLogPath(),
            $this->getAccessLogPath()
        ];
    }

    public function restartServer()
    {
        shell_exec("service nginx restart");
    }
}
