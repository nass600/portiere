<?php

namespace Portiere\Command;

use Portiere\Builder\NginxBuilder;
use Portiere\Vhost;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

/**
 * Class VhostListCommand
 *
 * @author Ignacio Velazquez <ignaciovelazquez@mobail.es>
 */
class VhostListCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName("vhost:list")
            ->setDescription("List vhosts");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders(['Vhost Name', 'Enabled']);

        $builder = new NginxBuilder(new Vhost(''));
        $config = $builder->getConfig();

        $finder = new Finder();
        $enabled = [];
        foreach ($finder->files()->in($config['sitesEnabledPath']) as $file) {
            $enabled[] = $file->getFilename();
        }

        $finder = new Finder();
        foreach ($finder->files()->in($config['sitesAvailablePath']) as $file) {
            $table->addRow([$file->getFilename(), in_array($file->getFilename(), $enabled)]);
        }

        $table->render();
    }
}
