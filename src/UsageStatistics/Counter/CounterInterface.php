<?php
namespace Jpietrzyk\UsageStatistics\Counter;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;


/**
 * Class Counter
 *
 * Count and add values to lists
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
interface CounterInterface
{
    /**
     * @param ArrayPathFinder $pathFinder
     * @param Resultset $resultSet
     * @return bool
     */
    public function inspect(ArrayPathFinder $pathFinder, Resultset $resultSet);
}