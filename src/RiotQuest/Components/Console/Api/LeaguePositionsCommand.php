<?php

namespace RiotQuest\Components\Console\Api;

use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LeaguePositionsCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('API Implementation for the League V4 Endpoints')
            ->setHelp('This command loads the different V4 Endpoints')
            ->setName('league:positions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENV === 'CLI') {

        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
