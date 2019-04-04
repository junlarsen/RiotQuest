<?php

namespace RiotQuest\Components\Console\Mastery;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IdCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Mastery::id()')
            ->setHelp('Mastery::id() function in the CLI')
            ->setName('mastery:id')
            ->addArgument('region', InputArgument::REQUIRED, 'Region')
            ->addArgument('id', InputArgument::REQUIRED, 'Summoner ID')
            ->addArgument('champion', InputArgument::REQUIRED, 'Champion ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::mastery($input->getArgument('region'))->id($input->getArgument('id'), $input->getArgument('champion'));
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
