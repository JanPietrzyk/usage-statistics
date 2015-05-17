<?php


namespace Jpietrzyk\UsageStatisticsCommand;

use Cilex\Command\Command;
use Jpietrzyk\UsageStatistics\ArrayPathFinder;
use Jpietrzyk\UsageStatistics\Counter;
use Jpietrzyk\UsageStatistics\Handler\GenerateStatistics\Config;
use Jpietrzyk\UsageStatistics\Handler\GenerateStatistics\GenerateStatisticsHandler;
use Jpietrzyk\UsageStatistics\ListCollector;
use Jpietrzyk\UsageStatistics\Loader\FileLoader;
use Jpietrzyk\UsageStatistics\StatisticGenerator;
use Jpietrzyk\UsageStatistics\Validator\ItemValidator;
use Jpietrzyk\UsageStatistics\ValueInterpreter\PHPVersionStringInterpreter;
use Jpietrzyk\UsageStatistics\ValueInterpreter\PrefixStrip;
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
        $config = new Config(new FileLoader(ROOT_DIRECTORY . '/resource'));

        $devVersionValidator = new ItemValidator('versions.dev-master');

        $config->addGenerator($this->getPHPVersionGenerator($devVersionValidator));
        $config->addGenerator($this->getKeywordGenerator($devVersionValidator));
        $config->addGenerator($this->getExtensionGenerator($devVersionValidator));


        $handler = new GenerateStatisticsHandler();
        $result = $handler->execute($config);

        file_put_contents(
            ROOT_DIRECTORY . '/stats/' . date('Y-m-d') . '-stats.json',
            serialize($result->get())
        );

        $output->writeln(print_r($result->get(), true));
    }

    private function getPHPVersionGenerator($devVersionValidator)
    {
        return new StatisticGenerator(
            new Counter\ScalarValueCounter(
                'versions.dev-master.require.php',
                new PHPVersionStringInterpreter()
            ),
            [
                $devVersionValidator
            ],
            $this->createDefaultListCollectors()
        );
    }

    private function getKeywordGenerator($devVersionValidator) {
        return new StatisticGenerator(
            new Counter\ArrayCounter(
                'versions.dev-master.keywords'
            ),
            [
                $devVersionValidator
            ],
            $this->createDefaultListCollectors()
        );
    }

    private function getExtensionGenerator($devVersionValidator) {
        return new StatisticGenerator(
            new Counter\ArrayKeyCounter(
                'versions.dev-master.require',
                new PrefixStrip('ext-')
            ),
            [
                $devVersionValidator
            ],
            $this->createDefaultListCollectors()
        );
    }

    private function createDefaultListCollectors() {
        return   [
            new ListCollector(
                'name',
                'downloads.total'
            ),
            new ListCollector(
                'name',
                'downloads.monthly'
            ),
        ];
    }
}
