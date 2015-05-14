<?php


namespace Jpietrzyk\UsageStatistics\Validator;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;

/**
 * Class ItemValidator
 *
 * Validate if a certain path exists or has a specific value
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class ItemValidator implements Validator
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var null|mixed
     */
    private $expectedValue;

    /**
     * @param string $path
     * @param null $expectedValue
     * @throws \InvalidArgumentException
     */
    public function __construct($path, $expectedValue = null)
    {
        if (is_array($expectedValue) || is_object($expectedValue)) {
            throw new \InvalidArgumentException('Invalid expected value - only not null primitives are supported');
        }

        $this->path = $path;
        $this->expectedValue = $expectedValue;
    }

    /**
     * @param ArrayPathFinder $pathFinder
     * @return bool
     */
    public function isValid(ArrayPathFinder $pathFinder)
    {
        try {
            $value = $pathFinder->requireValue($this->path);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        if (!isset($this->expectedValue)) {
            return true;
        }

        return $value == $this->expectedValue;
    }
}
