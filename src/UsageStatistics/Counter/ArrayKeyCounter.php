<?php


namespace Jpietrzyk\UsageStatistics\Counter;

use Jpietrzyk\UsageStatistics\PathFinder;
use Jpietrzyk\UsageStatistics\ValueInterpreter\ValueInterpreter;

/**
 * Class Counter
 *
 * Count array keys
 *
 * @package Jpietrzyk\UsageStatistics\Counter
 */
class ArrayKeyCounter implements CounterInterface
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

        if(!is_array($values)) {
            throw new \RuntimeException('Invalid path supplied');
        }

        foreach(array_keys($values) as $value) {
            try {
                $value = $this->interpreter->getRealValue($value);
            } catch(\InvalidArgumentException $e) {
                continue;
            }

            $resultSet->incValue($value);
        }
    }
}
