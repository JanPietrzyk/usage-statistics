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
use Jpietrzyk\UsageStatistics\Handler\Init\InitHandler;
use Jpietrzyk\UsageStatistics\Handler\Init\RawPackage;
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

        $packageNames = $client->all();
        $resourceRoot = ROOT_DIRECTORY . '/resource';

        $handler = new InitHandler($resourceRoot, count($packageNames));


        foreach ($packageNames as $packageName) {
            $output->writeln($packageName);

            $rawPackage = new RawPackage(
                $packageName,
                (array) $client->get($packageName)
            );

            $messages = $handler->addPackage($rawPackage);

            foreach($messages->getMessages() as $messages) {
                $output->writeln($messages);
            }
        }

        $output->writeln('text');
    }
}
