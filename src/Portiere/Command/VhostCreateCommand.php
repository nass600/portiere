<?php

namespace Portiere\Command;

use Portiere\WebServer\ManagerFactory;
use Portiere\WebServer\Vhost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class VhostCreateCommand.
 *
 * @author Ignacio Velazquez <ivelazquez85@gmail.com>
 */
class VhostCreateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('vhost:create')
            ->setDescription('Creates a vhost for this project')
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

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $vhostFilename = $input->getOption('vhost-filename');

        if (null === $vhostFilename) {
            $vhostFilename = $input->getArgument('serverName');
        }

        $vhost = new Vhost($vhostFilename);
        $vhost
            ->setServerName($input->getArgument('serverName'))
            ->setDocumentRoot($input->getArgument('documentRoot'))
            ->setEnv($input->getOption('no-dev') ? Vhost::ENV_PROD : Vhost::ENV_DEV);

        $manager = ManagerFactory::create();

        // Dumping a preview
        $io->newLine();
        $io->writeln("The vhost file <info>{$manager->getVhostAvailablePath($vhost)}</info> will look like:");
        $io->newLine();

        $io->text($manager->getTemplate($vhost));

        if (!$io->confirm('Do you confirm the vhost generation?', true)) {
            $io->warning('Canceled!! The vhost has not been created due to user interruption');

            return;
        }

        $manager->createVhost($vhost);
        $manager->restartServer();

        $io->success('Your vhost has been successfully created and enabled');

        $io->newLine();
        $output->writeln('You should append this line to your <info>/etc/hosts</info> file:');
        $io->newLine();
        $output->writeln("<info>127.0.0.1\t{$vhost->getServerName()}</info>\n");
    }
}
