<?php

namespace Portiere\Command;

use Portiere\Builder\NginxBuilder;
use Portiere\Vhost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
            ->setName("vhost:create")
            ->setDescription("Creates a vhost for this project")
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
                'no-dev',
                'no-dev',
                InputOption::VALUE_NONE,
                'Don\'t add Symfony2 dev front controller'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getHelper('question');
        $output->getFormatter()->setStyle('sample', new OutputFormatterStyle('yellow'));

        $vhostFilename = $input->getOption('vhost-filename');

        if (null === $vhostFilename) {
            $vhostFilename = $input->getArgument('serverName');
        }

        $vhost = new Vhost($vhostFilename);
        $vhost
            ->setServerName($input->getArgument('serverName'))
            ->setDocumentRoot($input->getArgument('documentRoot'))
            ->setEnv($input->getOption('no-dev') ? Vhost::ENV_PROD : Vhost::ENV_DEV);

        $builder = new NginxBuilder($vhost);

        // Dumping a preview
        $output->writeln("\nThe vhost file <info>{$builder->getVhostAvailablePath()}</info> will look like:\n");

        $output->writeln("<sample>{$builder->getTemplate()}</sample>");

        // Confirm generation
        $question = new ConfirmationQuestion(
            "\n<question>Do you confirm the vhost generation? (y/n)</question> ",
            false
        );

        if (!$questionHelper->ask($input, $output, $question)) {
            $output->writeln("\n<error>Canceled!!</error> The vhost has not been created due to user interruption\n");

            return;
        }

        $builder->createVhost()->restartServer();

        $output->writeln("\n<info>Awesome!!</info> Your vhost has been successfully created and enabled");

        $output->writeln("\nYou should append this line to your <info>/etc/hosts</info> file:\n");
        $output->writeln("<sample>127.0.0.1\t{$vhost->getServerName()}</sample>\n");
    }
}
