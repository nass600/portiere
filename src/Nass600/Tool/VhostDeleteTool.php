<?php

namespace Nass600\Tool;

use Nass600\Command\VhostDeleteCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class VhostDeleteTool
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostDeleteTool extends Application
{
    /**
     * {@inheritDoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'nass600:vhost:delete';
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new VhostDeleteCommand();

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
