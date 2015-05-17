<?php


namespace Jpietrzyk\UsageStatistics\Handler\GenerateStatistics;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;

/**
 * Class GenerateStatisticsHandler
 * @package Jpietrzyk\UsageStatistics\Handler\GenerateStatistics
 */
class GenerateStatisticsHandler
{

    /**
     * @param Config $config
     * @return Result
     */
    public function execute(Config $config)
    {
        $generator = $config->getLoader()->getGenerator();

        /** @var array $item */
        foreach ($generator() as $item) {
            $pathFinder = new ArrayPathFinder($item);

            foreach ($config->getGenerators() as $counter) {
                $counter->inspect($pathFinder);
            }
        }

        $result = new Result();

        foreach ($config->getGenerators() as $name => $counter) {
            $result->add($name, $counter->getRawResult());
        }

        return $result;
    }
}
