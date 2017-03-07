<?php

namespace WebServer\VhostBuilder;

use PHPUnit\Framework\TestCase;
use Portiere\WebServer\NginxManager;
use Portiere\WebServer\Vhost;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\PhpEngine;

/**
 * Class NginxManagerTest
 *
 * @package WebServer\VhostBuilder
 */
class NginxManagerTest extends TestCase
{
    public function getManagerMock()
    {
        $fs = $this->createMock(Filesystem::class);
        $templating = $this->createMock(PhpEngine::class);

        return new NginxManager($fs, $templating);
    }

    public function testVhostAvailablePath()
    {
        $vhost = new Vhost('test');

        $manager = $this->getManagerMock();
        $this->assertEquals('/etc/nginx/sites-available/test', $manager->getVhostAvailablePath($vhost));
    }

    public function testVhostEnabledPath()
    {
        $vhost = new Vhost('test');

        $manager = $this->getManagerMock();
        $this->assertEquals('/etc/nginx/sites-enabled/test', $manager->getVhostEnabledPath($vhost));
    }
}
