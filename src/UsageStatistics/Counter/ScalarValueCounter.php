<?php


namespace Jpietrzyk\UsageStatistics\Counter;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;
use Jpietrzyk\UsageStatistics\ValueInterpreter\ValueInterpreter;

/**
 * Class Counter
 *
 * Count scalar values
 *
 * @package Jpietrzyk\UsageStatistics\Counter
 */
class ScalarValueCounter implements CounterInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var ValueInterpreter
     */
    private $interpreter;

    /**
     * @param $path
     * @param ValueInterpreter $interpreter
     */
    public function __construct($path, ValueInterpreter $interpreter)
    {
        $this->path = (string) $path;
        $this->interpreter = $interpreter;
    }

    /**
     * @param ArrayPathFinder $pathFinder
     * @param Resultset $resultSet
     * @return bool
     */
    public function inspect(ArrayPathFinder $pathFinder, Resultset $resultSet)
    {
        try {
            $value = $pathFinder->requireValue($this->path);
        } catch (\InvalidArgumentException $e) {
            $resultSet->setNotFound();
            return false;
        }

        $filteredValue = $this->interpreter->getRealValue($value);

        $resultSet->incValue($filteredValue);
        return true;
    }
}
