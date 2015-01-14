<?php

namespace Nass600\Command\Tests;

use Nass600\Command\VhostCreateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class VhostCreateCommandTest
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostCreateCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new Application();
        $this->app->add(new VhostCreateCommand());
    }

    public function testCommand($parameters = array())
    {
        $command = $this->app->find('vhost:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
    }
}
