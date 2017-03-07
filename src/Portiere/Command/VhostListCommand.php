<?php

namespace Portiere\Command;

use Portiere\WebServer\ManagerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class VhostListCommand.
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostListCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('vhost:list')
            ->setDescription('List vhosts');
    }

    /**
     * {@inheritdoc}
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
