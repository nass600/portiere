<?php

namespace Nass600\Command;

use Nass600\Builder\NginxBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

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
            ->setDescription("Deletes an vhost from the webserver")
            ->addOption(
                'server',
                's',
                InputOption::VALUE_OPTIONAL,
                'Which server are you using?'
            )
            ->addOption(
                'server-name',
                'sn',
                InputOption::VALUE_OPTIONAL,
                'Which is the server name?'
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = [];

        $question = $this->getHelper('question');
        $dialog = $this->getHelper('dialog');

        // Httpd server
        $config['server'] = $input->getOption('server');
        if (null === $config['server']) {
            $serverQuestion = new ChoiceQuestion(
                '<info>Which server are you using? <comment>(default: nginx)</comment></info> ',
                array('nginx', 'apache'),
                0
            );
            $serverQuestion->setErrorMessage('Web server %s not supported.');

            $config['server'] = $question->ask($input, $output, $serverQuestion);
        }

        // Server name
        $config['serverName'] = $input->getOption('server-name');
        if (null === $config['serverName']) {
            $serverNameQuestion = new Question('<info>Which is the server name?</info> ');

            $config['serverName'] = $question->ask($input, $output, $serverNameQuestion);
        }

        $builder = new NginxBuilder($config);

        $config = $builder->getConfig();

        $filesToDelete = [
            $config['sitesAvailablePath'] . $config['serverName'],
            $config['sitesEnabledPath'] . $config['serverName'],
            $config['logsDir'] . $config['serverName'] . '.error',
            $config['logsDir'] . $config['serverName'] . '.access'
        ];

        // Dumping a preview
        $output->writeln("\n<info>We are going to delete this files:</info>");

        foreach($filesToDelete as $file) {
            $output->writeln("<comment>$file</comment>");
        }

        // Confirm generation
        if (!$dialog->askConfirmation(
            $output,
            "\n<question>Do you agree?</question> ",
            false
        )) {
            $output->writeln(
                "<error>The vhost has not been deleted due to user interruption</error>"
            );
            return;
        }

        $builder->deleteVhost()->restartService();

        $output->writeln("\nAwesome!! <info>Your vhost has been successfully deleted</info>");
    }
}
 