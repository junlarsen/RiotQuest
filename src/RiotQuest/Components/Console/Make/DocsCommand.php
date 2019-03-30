<?php

namespace RiotQuest\Components\Console\Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RiotQuest\Docs\Generator;

/**
 * Class DocsCommand
 *
 * Command to write out the documentation files
 *
 * @package RiotQuest\Components\Console\Make
 */
class DocsCommand extends Command
{

    protected static $defaultName = 'make:docs';

    protected function configure()
    {
        $this
            ->setDescription('Generates the Documentation files.')
            ->setHelp('This automatically builds the docs for the framework.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<info>================================</info>',
            '* RiotQuest CLI 1.0              ',
            '<info>================================</info>'
        ]);

        $output->writeln('- Generating Documentation');

        $gen = new Generator\Generator();
        $gen->collections();

        $output->writeln('- Completed Collections');

        $gen->sidebar();

        $output->writeln([
            '- Completed Sidebar',
            '- Completed Generation',
            '<info>================================</info>'
        ]);
    }

}
