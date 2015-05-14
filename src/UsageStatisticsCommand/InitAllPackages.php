<?php

/*
 * This file is part of the Cilex framework.
 *
 * (c) Mike van Riel <mike.vanriel@naenius.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jpietrzyk\UsageStatisticsCommand;

use Cilex\Command\Command;
use Jpietrzyk\PackagistApiExtended\ArrayResultFactory;
use Packagist\Api\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Example command for testing purposes.
 */
class InitAllPackages extends Command
{
    protected function configure()
    {
        $this
            ->setName('setup:initpackages')
            ->setDescription('Load initial packages into fs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client(
            null,
            new ArrayResultFactory()
        );

        $resourceRoot = ROOT_DIRECTORY . '/resource';


        foreach ($client->all() as $packageName) {
            $output->writeln($packageName);

            $package = $client->get($packageName);


            file_put_contents(
                $resourceRoot . '/' . str_replace('/', '___', $packageName) . '.cache',
                var_export($package, true)
            );
        }

        $output->writeln('text');
    }
}
