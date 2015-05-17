<?php


namespace Jpietrzyk\UsageStatistics\Counter;

use Jpietrzyk\UsageStatistics\PathFinder;
use Jpietrzyk\UsageStatistics\ValueInterpreter\ValueInterpreter;

/**
 * Class Counter
 *
 * Count array values
 *
 * @package Jpietrzyk\UsageStatistics\Counter
 */
class ArrayCounter implements CounterInterface
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
    public function __construct($path, ValueInterpreter $interpreter = null)
    {
        $this->path = (string) $path;
        $this->interpreter = $interpreter;
    }

    /**
     * @param PathFinder $pathFinder
     * @param Resultset $resultSet
     * @return bool
     */
    public function inspect(PathFinder $pathFinder, Resultset $resultSet)
    {
        try {
            $values = $pathFinder->requireValue($this->path);
        } catch (\InvalidArgumentException $e) {
            $resultSet->setNotFound();
            return;
        }

        foreach ($values as $value) {
            if ($this->interpreter) {
                $value = $this->interpreter->getRealValue($value);
            }

            $resultSet->incValue($value);
        }
    }
}
