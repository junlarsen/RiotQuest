<?php

namespace RiotQuest\Components\Console\Champion;

use RiotQuest\Components\Framework\Client\Client;
use RiotQuest\Contracts\RiotQuestException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RotationCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Champion::rotation()')
            ->setHelp('Champion::rotation() function in the CLI')
            ->setName('champion:rotation')
            ->addArgument('region', InputArgument::REQUIRED, 'Region');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (RIOTQUEST_ENVLOAD) {
            $out = Client::champion($input->getArgument('region'))->rotation();
            $output->write(json_encode($out));
        } else {
            throw new RiotQuestException("App needs to be loaded using Environment to use RiotQuest from CLI.");
        }
    }

}
