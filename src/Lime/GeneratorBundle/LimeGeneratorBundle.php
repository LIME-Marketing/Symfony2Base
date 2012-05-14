<?php

namespace Lime\GeneratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Override of SensioGeneratorBundle. This bundle provides access to editable files
 * that can be used to generate bundles, crud and forms.
 * 
 * @author ms2474@gmail.com <ms2474@gmail.com> 
 */
class LimeGeneratorBundle extends Bundle
{
    public function registerCommands(Application $application){

        // Construct new generators
        $crudGenerator   = new DoctrineCrudGenerator(new FileSystem, __DIR__.'/Resources/skeleton/crud');
        $bundleGenerator = new BundleGenerator(new FileSystem, __DIR__.'/Resources/skeleton/bundle');

        // Capture generation commands
        $bundleCommand = $application->get('generate:bundle');
        $crudCommand   = $application->get('generate:doctrine:crud');

        // Set generator for commands
        $crudCommand->setGenerator($crudGenerator);
        $bundleCommand->setGenerator($bundleGenerator);

        // Register new commands
        parent::registerCommands($application);
    }
}