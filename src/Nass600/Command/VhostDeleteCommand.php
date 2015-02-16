<?php

namespace Nass600\Command;

use Nass600\Builder\NginxBuilder;
use Nass600\Builder\Vhost;
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
            ->setName("nass600:vhost:delete")
            ->setDescription("Deletes an vhost from the web server")
            ->addArgument(
                'vhostFilename',
                InputArgument::REQUIRED,
                'Vhost filename'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');

        $vhost = new Vhost($input->getArgument('vhostFilename'));

        $builder = new NginxBuilder($vhost);

        $output->writeln("\nThe following files are going to be <error>deleted</error>:\n");

        foreach($builder->getGeneratedFiles() as $file) {
            $output->writeln("<comment>{$file}</comment>");
        }

        // Confirm generation
        if (!$dialog->askConfirmation(
            $output,
            "\n<question>Do you confirm the removal of the vhost?</question> ",
            true
        )) {
            $output->writeln(
                "\n<error>Canceled!!</error> The vhost has not been deleted due to user interruption\n"
            );
            return;
        }

        $builder->deleteVhost()->restartServer();

        $output->writeln("\n<info>Awesome!!</info> Your vhost has been successfully deleted\n");
    }
}
