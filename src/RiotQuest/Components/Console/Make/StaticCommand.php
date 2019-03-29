<?php

namespace RiotQuest\Components\Console\Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RiotQuest\Components\DataProvider\DataDragon\Assets;

class TemplatesCommand extends Command
{

    protected static $defaultName = 'make:static';

    protected function configure()
    {
        $this
            ->setDescription('Generates the static assets for a locale.')
            ->setHelp('Gather all static assets for certain locale')
            ->addArgument('locale', InputArgument::REQUIRED, 'The locate to target');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<info>================================</info>',
            '* RiotQuest CLI 1.0              ',
            '<info>================================</info>'
        ]);

        $output->writeln([
            '- Generating Static Assets',
        ]);

        Assets::setLocate($input->getArgument('locale'));
        foreach (Assets::$map as $key => $value)
        {
            Assets::update($key);
        }

        $output->writeln([
            '- Completed Static Asset Generation',
        ]);

        $output->writeln([
            '<info>================================</info>'
        ]);
    }

}
