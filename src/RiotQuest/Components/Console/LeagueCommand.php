<?php

namespace RiotQuest\Components\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LeagueCommand extends Command
{

    protected static $defaultName = 'api:league';

    protected function configure()
    {
        $this
            ->setDescription('API Implementation for the League V4 Endpoints')
            ->setHelp('This command loads the different V4 Endpoints');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<info>TODO</info>'
        ]);
    }

}
