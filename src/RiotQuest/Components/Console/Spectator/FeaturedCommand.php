<?php

namespace RiotQuest\Components\Console\Spectator;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FeaturedCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Spectator::id()')
            ->setHelp('Spectator::featured() function in the CLI')
            ->setName('spectator:featured')
            ->addArgument('region', InputArgument::REQUIRED, 'Region');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::spectator($input->getArgument('region'))->featured();
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
