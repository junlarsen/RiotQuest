<?php

namespace RiotQuest\Components\CommandLine;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RiotQuest\Docs\Generator;

class CreateDocumentationCommand extends Command
{

    protected static $defaultName = 'docs:make';

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
            ' RiotQuest CLI 1.0              ',
            '<info>================================</info>'
        ]);

        $output->writeln([
            '- Generating Documentation',
        ]);

        (new Generator())->make();

        $output->writeln([
            '- Completed Generation',
        ]);

        $output->writeln([
            '<info>================================</info>'
        ]);
    }

}
