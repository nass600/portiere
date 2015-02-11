<?php

namespace Nass600\Builder;

class NginxBuilder extends Builder
{
    const TEMPLATE_FILE = 'nginx.php';

    protected $config = [
        'sitesAvailablePath' => '/etc/nginx/sites-available/',
        'sitesEnabledPath'   => '/etc/nginx/sites-enabled/',
        'logsDir'            => '/var/logs/nginx/',
        'hostsFilePath'      => '/etc/hosts'
    ];

    public function __construct($config)
    {
        parent::__construct(array_merge($this->config, $config));
    }

    public function getTemplate()
    {
        return $this->templating->render(self::TEMPLATE_FILE, $this->config);
    }

    public function createVhost()
    {
        $template = $this->getTemplate();
        $vhostPath = "{$this->config['sitesAvailablePath']}{$this->config['vhostFilename']}";
        $vhostSymPath = "{$this->config['sitesEnabledPath']}{$this->config['vhostFilename']}";

        $this->fs->dumpFile($vhostPath, $template);
        $this->fs->symlink($vhostPath, $vhostSymPath);

        return $this;
    }

    public function restartService()
    {
        shell_exec("service nginx restart");
    }
}