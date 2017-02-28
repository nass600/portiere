<?php

namespace Portiere\Command;

use Portiere\WebServer\ManagerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class VhostListCommand
 *
 * @package Portiere\Command
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostListCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName("vhost:list")
            ->setDescription("List vhosts");
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $manager = ManagerFactory::create();

        $io->table(
            ['Vhost Name', 'Enabled'],
            $manager->listVhosts()
        );
    }
}
