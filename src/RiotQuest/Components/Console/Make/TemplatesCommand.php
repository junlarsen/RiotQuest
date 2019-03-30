<?php

namespace RiotQuest\Components\Console\Make;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RiotQuest\Components\Framework\Engine\Filesystem;

/**
 * Class TemplatesCommand
 *
 * Command to generate Collection templates
 *
 * @package RiotQuest\Components\Console\Make
 */
class TemplatesCommand extends Command
{

    protected static $defaultName = 'make:templates';

    protected function configure()
    {
        $this
            ->setDescription('Generates the collection template files.')
            ->setHelp('This automatically builds the collection templates for the framework.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '<info>================================</info>',
            '* RiotQuest CLI 1.0              ',
            '<info>================================</info>'
        ]);

        $output->writeln('- Generating Templates');

        $gen = new Filesystem();
        $gen->generateTemplates();

        $output->writeln([
            '- Completed Template Generation',
            '<info>================================</info>'
        ]);
    }

}
