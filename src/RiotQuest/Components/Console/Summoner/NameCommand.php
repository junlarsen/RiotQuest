<?php

namespace RiotQuest\Components\Console\Summoner;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NameCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('The Summoner::name function in CLI')
            ->setHelp('Summoner V4 / by-name implementation.')
            ->setName('summoner:name')
            ->addArgument('region', InputArgument::REQUIRED, 'Region to request to.')
            ->addArgument('name', InputArgument::REQUIRED, 'Summoner name to look up.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::summoner($input->getArgument('region'))->name($input->getArgument('name'));
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
