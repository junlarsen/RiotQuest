<?php

namespace RiotQuest\Components\Console\League;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\ConsoleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChallengerCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('League::challenger()')
            ->setHelp('League::challenger() function in the CLI')
            ->setName('league:challenger')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'Queue Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::league($input->getArgument('region'))->challenger($input->getArgument('id'));
            $output->write(json_encode($out));
        } else {
            throw new ConsoleException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
