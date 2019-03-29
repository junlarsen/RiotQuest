<?php

namespace RiotQuest\Components\Console\Cache;

use RiotQuest\Components\Framework\Engine\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends Command
{

    protected function configure()
    {
        $this
            ->setDescription('Clear a cache component.')
            ->setHelp('Clears a cache component. "templates", "limits"')
            ->setName('cache:clear')
            ->addArgument('entity', InputArgument::REQUIRED, 'Cache to clear.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<info>================================</info>',
            '* RiotQuest CLI 1.0              ',
            '<info>================================</info>'
        ]);

        $output->writeln([
            '- Cleaning Cache',
        ]);

        $gen = new Filesystem();
        switch ($input->getArgument('entity')) {
            case 'templates':
                $gen->flushTemplates();
        }

        $output->writeln([
            '- Cache Flushed',
        ]);

        $output->writeln([
            '<info>================================</info>'
        ]);
    }

}
