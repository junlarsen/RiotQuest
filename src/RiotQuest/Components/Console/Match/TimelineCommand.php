<?php

namespace RiotQuest\Components\Console\Match;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\ConsoleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TimelineCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Match::timeline()')
            ->setHelp('Match::timeline() function in the CLI')
            ->setName('match:timeline')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'Match ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::match($input->getArgument('region'))->timeline($input->getArgument('id'));
            $output->write(json_encode($out));
        } else {
            throw new ConsoleException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
