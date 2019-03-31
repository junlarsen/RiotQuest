<?php

namespace RiotQuest\Components\Console\Summoner;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AccountCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Summoner::account()')
            ->setHelp('Summoner::account() function in the CLI')
            ->setName('summoner:account')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'Account ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::summoner($input->getArgument('region'))->account($input->getArgument('id'));
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
