<?php

namespace RiotQuest\Components\Console\League;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShardCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Status::shard()')
            ->setHelp('Status::shard() function in the CLI')
            ->setName('status:command')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'Summoner ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::league($input->getArgument('region'))->positions($input->getArgument('id'));
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
