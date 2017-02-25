<?php

namespace Portiere;

use Portiere\Command\VhostCreateCommand;
use Portiere\Command\VhostDeleteCommand;
use Portiere\Command\VhostListCommand;
use Symfony\Component\Console\Application;

/**
 * Class Portiere
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class Portiere extends Application
{
    /**
     * {@inheritDoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new VhostCreateCommand();
        $defaultCommands[] = new VhostDeleteCommand();
        $defaultCommands[] = new VhostListCommand();

        return $defaultCommands;
    }
}
