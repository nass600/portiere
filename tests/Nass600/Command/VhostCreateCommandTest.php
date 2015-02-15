<?php

namespace Nass600\Command\Tests;

use Nass600\Command\VhostDeleteCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class VhostDeleteCommandTest
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostDeleteCommandTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new Application();
        $this->app->add(new VhostDeleteCommand());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testNotEnoughArguments()
    {
        $command = $this->app->find('nass600:vhost:delete');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName()
        ));
    }
}
