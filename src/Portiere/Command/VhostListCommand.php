<?php

namespace Portiere\Command;

use Portiere\Builder\NginxBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VhostListCommand
 *
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("vhost:list")
            ->setDescription("List vhosts");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Vhost Name', 'Enabled']);

        $builder = new NginxBuilder();

        $table->setRows($builder->listVhost());

        $table->render();
    }
}
