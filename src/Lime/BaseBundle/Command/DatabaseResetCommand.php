<?php

namespace Lime\BaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * @author Michael Shattuck <ms2474@gmail.com>
 */
class DatabaseResetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('db:reset')
            ->setDescription('Drops and and empty database, updates the schema and populates defaults.')
            ->setHelp(<<<EOT
The <info>lime:database:update</info> command is used to reset the application database.
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Drop the current database
        $output->writeln(sprintf('<comment>Dropping the current database...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('php app/console doctrine:database:drop --force').'</info>'));

        // Create an empty database
        $output->writeln(sprintf('<comment>Creating a new database...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('php app/console doctrine:database:create').'</info>'));

        // Create the different tables in the database
        $output->writeln(sprintf('<comment>Updating the schema...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('php app/console doctrine:schema:update --force').'</info>'));

        // Populate the configuration defaults
        $output->writeln(sprintf('<comment>Populating configuration defaults...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('php app/console lime:admin:init').'</info>'));

        // Clear the cache
        $output->writeln(sprintf('<comment>Dumping the app/cache folder...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('rm -rf app/cache/*').'</info>'));

        $output->writeln(sprintf('<comment>Dumping the app/logs folder...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('rm -rf app/logs/*').'</info>'));

        $output->writeln(sprintf('<comment>Resetting the bootstrap.php.cache file...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('rm app/bootstrap.php.cache').'</info>'));
        $output->writeln(sprintf('<info>'.shell_exec('touch app/bootstrap.php.cache').'</info>'));

        $output->writeln(sprintf('<comment>Finally Running the clear cache command...</comment>'));
        $output->writeln(sprintf('<info>'.shell_exec('php app/console cache:clear').'</info>'));

        // Completion
        $output->writeln(sprintf('<info>The database has been successfully reset. Enjoy!</info>'));
    }
}