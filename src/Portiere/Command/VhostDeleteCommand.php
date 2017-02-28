<?php

namespace Portiere\Command;

use Portiere\WebServer\ManagerFactory;
use Portiere\WebServer\Vhost;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class VhostDeleteCommand
 *
 * @package Portiere\Command
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostDeleteCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName("vhost:delete")
            ->setDescription("Deletes a vhost from the web server")
            ->addArgument(
                'vhostFilename',
                InputArgument::REQUIRED,
                'Vhost filename'
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $questionHelper = $this->getHelper('question');

        $vhost = new Vhost($input->getArgument('vhostFilename'));

        $manager = ManagerFactory::create();

        $io->warning("The following files are going to be deleted");

        $io->listing($manager->getGeneratedFiles($vhost));

        if (!$io->confirm('Do you confirm the removal of the vhost?', true)) {
            $io->warning("Canceled!! The vhost has not been deleted due to user interruption");

            return;
        }

        $manager->deleteVhost($vhost);
        $manager->restartServer();

        $io->success("Awesome!! Your vhost has been successfully deleted");
    }
}
