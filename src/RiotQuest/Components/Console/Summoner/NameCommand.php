<?php

namespace RiotQuest\Components\Console\Summoner;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\ConsoleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NameCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Summoner::name()')
            ->setHelp('Summoner::name() function in the CLI')
            ->setName('summoner:name')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('name', InputArgument::REQUIRED, 'Summoner Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::summoner($input->getArgument('region'))->name($input->getArgument('name'));
            $output->write(json_encode($out));
        } else {
            throw new ConsoleException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
