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

    /**
     * @expectedException RuntimeException
     */
    public function testNotEnoughArguments()
    {
        $command = $this->app->find('nass600:vhost:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName()
        ));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testMissingServerNameArgument()
    {
        $command = $this->app->find('nass600:vhost:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'documentRoot' => '/fakeDir'
        ));
    }

    /**
     * @expectedException RuntimeException
     */
    public function testMissingDocumentRootArgument()
    {
        $command = $this->app->find('nass600:vhost:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'serverName'   => 'example.com'
        ));
    }
}
