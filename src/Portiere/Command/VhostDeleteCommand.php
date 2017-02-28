<?php

namespace Portiere\Command;

use Portiere\WebServer\Vhost;
use Portiere\WebServer\NginxManager;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VhostDeleteCommand
 *
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostDeleteCommand extends Command
{
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');

        $vhost = new Vhost($input->getArgument('vhostFilename'));

        $manager = new NginxManager($vhost);

        $output->writeln("\nThe following files are going to be <error>deleted</error>:\n");

        foreach ($manager->getGeneratedFiles() as $file) {
            $output->writeln("<comment>{$file}</comment>");
        }

        $question = new ConfirmationQuestion(
            "\n<question>Do you confirm the removal of the vhost? (y/n)</question> ",
            true
        );

        // Confirm generation
        if (!$questionHelper->ask($input, $output, $question)) {
            $output->writeln(
                "\n<error>Canceled!!</error> The vhost has not been deleted due to user interruption\n"
            );
            return;
        }

        $manager->deleteVhost()->restartServer();

        $output->writeln("\n<info>Awesome!!</info> Your vhost has been successfully deleted\n");
    }
}
