<?php

namespace Nass600\Tool;

use Nass600\Command\VhostCreateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class VhostCreateTool
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostCreateTool extends Application
{
    /**
     * {@inheritDoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'nass600:vhost:create';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new VhostCreateCommand();

        return $defaultCommands;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}