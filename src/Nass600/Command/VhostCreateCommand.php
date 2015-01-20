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
            )
            ->addOption(
                'document-root',
                'dr',
                InputOption::VALUE_OPTIONAL,
                'Where is the project stored?'
            )
            ->addOption(
                'vhost-filename',
                'vf',
                InputOption::VALUE_OPTIONAL,
                'How would you like to name the vhost file?'
            )
            ->addOption(
                'error-logfile',
                'el',
                InputOption::VALUE_OPTIONAL,
                'How do you want to name the error log file?'
            )
            ->addOption(
                'access-logfile',
                'al',
                InputOption::VALUE_OPTIONAL,
                'How do you want to name the access log file?'
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

        // Document root
        $config['documentRoot'] = $input->getOption('document-root');
        if (null === $config['documentRoot']) {
            $documentRootQuestion = new Question('<info>Where is the project stored?</info> ', 'hello');

            $documentRootQuestion->setValidator(function ($answer) {
                if (!file_exists($answer)) {
                    throw new \RuntimeException(
                        'The path you inserted does not exist'
                    );
                }
                if (!is_dir($answer)) {
                    throw new \RuntimeException(
                        'The path you inserted is not a directory'
                    );
                }
                return $answer;
            });

            $config['documentRoot'] = $question->ask($input, $output, $documentRootQuestion);
        }

        // Vhost filename
        $config['vhostFilename'] = $input->getOption('vhost-filename');
        if (null === $config['vhostFilename']) {
            $vhostFilenameQuestion = new Question(
                "<info>How would you like to name the vhost file? " .
                "<comment>(default: {$config['serverName']})</comment></info> ",
                $config['serverName']
            );

            $config['vhostFilename'] = $question->ask($input, $output, $vhostFilenameQuestion);
        }

        // Error logfile
        $config['errorLogfile'] = $input->getOption('error-logfile');
        if (null === $config['errorLogfile']) {
            $errorLogfileQuestion = new Question(
                "<info>How do you want to name the error log file? " .
                "<comment>(default: {$config['serverName']}.error.log)</comment></info> ",
                "{$config['serverName']}.error.log"
            );

            $config['errorLogfile'] = $question->ask($input, $output, $errorLogfileQuestion);
        }

        // Access logfile
        $config['accessLogfile'] = $input->getOption('access-logfile');
        if (null === $config['accessLogfile']) {
            $accessLogfileQuestion = new Question(
                "<info>How do you want to name the access log file? " .
                "<comment>(default: {$config['serverName']}.access.log)</comment></info> ",
                "{$config['serverName']}.access.log"
            );

            $config['accessLogfile'] = $question->ask($input, $output, $accessLogfileQuestion);
        }

        $builder = new NginxBuilder($config);

        // Dumping a preview
        $output->writeln("\n<info>This is how the vhost file will look like:</info>");

        $output->writeln($builder->getTemplate());

        // Confirm generation
        if (!$dialog->askConfirmation(
            $output,
            "\n<question>Is every thing ok?</question> ",
            false
        )) {
            $output->writeln(
                "<error>The vhost has not been created due to user interruption</error>"
            );
            return;
        }

        $builder->createVhost()->restartService();

        $output->writeln("\nAwesome!! <info>Your vhost has been successfully created and enabled</info>");

        if (!$dialog->askConfirmation(
            $output,
            "\n<question>Do you want me to create the entry in the hosts file?</question> ",
            false
        )) {
            $output->writeln(
                "\nIf you change your mind the entry you must write is <info>127.0.0.1\t{$config['serverName']}</info>"
            );
            return;
        } else {
            // TODO: Write entry to hosts file
        }
    }
}
 