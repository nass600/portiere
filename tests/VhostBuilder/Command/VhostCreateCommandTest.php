<?php

namespace Portiere\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

/**
 * Class VhostCreateCommandTest
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostCreateCommandTest extends TestCase
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
        $command = $this->app->find('vhost:create');
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
        $command = $this->app->find('vhost:create');
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
        $command = $this->app->find('vhost:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'      => $command->getName(),
            'serverName'   => 'example.com'
        ));
    }
}
