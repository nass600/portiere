<?php

namespace Nass600\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

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
            ->setDescription("Creates an vhost for this project");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $loader = new FilesystemLoader(__DIR__.'/../Resources/views/%name%');
        $templating = new PhpEngine(new TemplateNameParser(), $loader);

        $fs = new Filesystem();

        // Httpd server
        $serverQuestion = new ChoiceQuestion(
            '<question>Which server are you using?</question> ',
            array('nginx', 'apache'),
            0
        );
        $serverQuestion->setErrorMessage('Web server %s not supported.');

        $server = $helper->ask($input, $output, $serverQuestion);

        // Server name
        $serverNameQuestion = new Question('<question>Which is the server name?</question> ');

        $serverName = $helper->ask($input, $output, $serverNameQuestion);

        // Document root
        $documentRootQuestion = new Question('<question>Where is the project stored?</question> ', 'hello');

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

        $documentRoot = $helper->ask($input, $output, $documentRootQuestion);

        $output = $templating->render('nginx.php', array(
            'serverName'   => $serverName,
            'documentRoot' => $documentRoot
        ));

        $nginxPath = "/etc/nginx/sites-available";
        $symlinkPath = "/etc/nginx/sites-enabled";

        $configFile = "$nginxPath/$serverName";

        $fs->dumpFile($configFile, $output);
        $fs->symlink($configFile, $symlinkPath."/".$serverName);

        shell_exec("service nginx restart");
    }
}
 