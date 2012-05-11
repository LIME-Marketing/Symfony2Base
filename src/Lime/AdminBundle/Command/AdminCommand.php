<?php

namespace Lime\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class AdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lime:admin:init')
            ->setDescription('Create and save all configuration defaults to the database.')
            ->setHelp(<<<EOT
The <info>lime:admin:init</info> command creates the configuration table in the database.
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getContainer()->get('database_connection');
        
        // Config Population
        $configManager   = $this->getContainer()->get('base_service_factory')->get('LimeAdminBundle:Config');
        $configConstants = $this->getContainer()->get('lime_admin.config.constants');

        $configResult = $configManager->commandInit($connection);

        if (!$configResult) {
            $output->writeln($configResult);
            return;
        }

        $configManager->populateDefaults($configConstants);

        $output->writeln(sprintf('Saved <info>configuration</info> defaults to database.'));
    }
}