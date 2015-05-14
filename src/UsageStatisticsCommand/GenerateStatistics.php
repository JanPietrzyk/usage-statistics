<?php


namespace Jpietrzyk\UsageStatisticsCommand;

use Cilex\Command\Command;
use Jpietrzyk\UsageStatistics\ArrayPathFinder;
use Jpietrzyk\UsageStatistics\Counter;
use Jpietrzyk\UsageStatistics\ListCollector;
use Jpietrzyk\UsageStatistics\Loader\FileLoader;
use Jpietrzyk\UsageStatistics\Validator\ItemValidator;
use Jpietrzyk\UsageStatistics\ValueInterpreter\PHPVersionStringInterpreter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateStatistics extends Command
{
    protected function configure()
    {
        $this
            ->setName('generate:statistics')
            ->setDescription('Load initial packages into fs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new FileLoader(ROOT_DIRECTORY . '/resource');

        $devVersionValidator = new ItemValidator('package.versions.dev-master');
        $phpVersionCollector = new Counter('package.versions.dev-master.require.php',
            [$devVersionValidator],
            new PHPVersionStringInterpreter(),
            [
                new ListCollector(
                    'package.name',
                    'package.downloads.total'
                ),
                new ListCollector(
                    'package.name',
                    'package.downloads.monthly'
                ),
            ]
        );

        $generator = $loader->getGenerator();

        $cnt = 0;
        /** @var array $item */
        foreach ($generator() as $item) {
            $pathFinder = new ArrayPathFinder($item);
            $phpVersionCollector->inspect($pathFinder);

            $cnt++;
            if (!($cnt % 1000)) {
                echo $cnt . "\n";
            }
        }

        file_put_contents(
            ROOT_DIRECTORY . '/stats/' . date('YY-m-d') . '-stats.json',
            json_encode($phpVersionCollector->getArrayResult())
        );

        $output->writeln(print_r($phpVersionCollector->getArrayResult(), true));
    }
}
