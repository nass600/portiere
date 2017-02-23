<?php

namespace VhostBuilder\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

/**
 * Class VhostDeleteCommandTest
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostDeleteCommandTest extends TestCase
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
        $command = $this->app->find('vhost:delete');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command' => $command->getName()
        ));
    }
}
