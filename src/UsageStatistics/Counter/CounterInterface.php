<?php
namespace Jpietrzyk\UsageStatistics\Counter;

use Jpietrzyk\UsageStatistics\PathFinder;

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
     * @param PathFinder $pathFinder
     * @param Resultset $resultSet
     * @return bool
     */
    public function inspect(PathFinder $pathFinder, Resultset $resultSet);
}
