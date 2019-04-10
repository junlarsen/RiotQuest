<?php

namespace RiotQuest\Components\Console\Summoner;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\ConsoleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UniqueCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Summoner::unique()')
            ->setHelp('Summoner::unique() function in the CLI')
            ->setName('summoner:unique')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'PUUID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::summoner($input->getArgument('region'))->unique($input->getArgument('id'));
            $output->write(json_encode($out));
        } else {
            throw new ConsoleException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
