<?php

namespace Nass600\Builder;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

abstract class Builder
{
    protected $config;

    protected $fs;

    protected $templating;

    public function __construct($config)
    {
        $this->config = $config;
        $this->fs = new Filesystem();

        $loader = new FilesystemLoader(__DIR__.'/../Resources/views/%name%');
        $this->templating = new PhpEngine(new TemplateNameParser(), $loader);
    }
}
