<?php

namespace Nass600\Command;

use Nass600\Builder\NginxBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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
            ->setDescription("Creates an vhost for this project");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = [];

        $helper = $this->getHelper('question');

        // Httpd server
        $serverQuestion = new ChoiceQuestion(
            '<info>Which server are you using? <comment>(default: nginx)</comment></info> ',
            array('nginx', 'apache'),
            0
        );
        $serverQuestion->setErrorMessage('Web server %s not supported.');

        $config['server'] = $helper->ask($input, $output, $serverQuestion);

        // Server name
        $serverNameQuestion = new Question('<info>Which is the server name?</info> ');

        $config['serverName'] = $helper->ask($input, $output, $serverNameQuestion);

        // Document root
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

        $config['documentRoot'] = $helper->ask($input, $output, $documentRootQuestion);

        // Vhost filename
        $vhostFilenameQuestion = new Question(
            "<info>How would you like to name the vhost file? " .
            "<comment>(default: {$config['serverName']})</comment></info> ",
            $config['serverName']
        );

        $config['vhostFilename'] = $helper->ask($input, $output, $vhostFilenameQuestion);

        $builder = new NginxBuilder($config);

        $builder->createVhost()->restartService();
    }
}
 