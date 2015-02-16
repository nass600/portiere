<?php

namespace Nass600\Command;

use Nass600\Builder\NginxBuilder;
use Nass600\Builder\Vhost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VhostCreateCommand
 *
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostCreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("nass600:vhost:create")
            ->setDescription("Creates an vhost for this project")
            ->addArgument(
                'serverName',
                InputArgument::REQUIRED,
                'Server name of the virtual host'
            )
            ->addArgument(
                'documentRoot',
                InputArgument::REQUIRED,
                'Path to the project\'s directory'
            )
            ->addOption(
                'vhost-filename',
                'vf',
                InputOption::VALUE_OPTIONAL,
                'Filename of the virtual host'
            )
            ->addOption(
                'env',
                'e',
                InputOption::VALUE_REQUIRED,
                'Symfony2 environment to activate',
                'dev'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $style = new OutputFormatterStyle('blue');
        $output->getFormatter()->setStyle('sample', $style);

        $vhostFilename = $input->getOption('vhost-filename');

        if (null === $vhostFilename) {
            $vhostFilename = $input->getArgument('serverName');
        }

        $vhost = new Vhost($vhostFilename);
        $vhost->setServerName($input->getArgument('serverName'))
            ->setDocumentRoot($input->getArgument('documentRoot'))
            ->setEnv($input->getOption('env'));

        $builder = new NginxBuilder($vhost);

        // Dumping a preview
        $output->writeln(
            "\nThe vhost file <info>{$builder->getVhostAvailablePath()}</info> will look like:\n"
        );

        $output->writeln("<sample>{$builder->getTemplate()}</sample>");

        // Confirm generation
        if (!$dialog->askConfirmation(
            $output,
            "\n<question>Do you confirm the vhost generation?</question> ",
            true
        )) {
            $output->writeln(
                "\n<error>Canceled!!</error> The vhost has not been created due to user interruption\n"
            );
            return;
        }

        $builder->createVhost()->restartServer();

        $output->writeln("\n<info>Awesome!!</info> Your vhost has been successfully created and enabled");

        $output->writeln("\nYou should append this line to your <info>/etc/hosts</info> file:\n");
        $output->writeln("<sample>127.0.0.1\t{$vhost->getServerName()}</sample>\n");
    }
}
