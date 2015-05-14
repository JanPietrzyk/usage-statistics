<?php
namespace Jpietrzyk\UsageStatistics\ValueInterpreter;

/**
 * Interface ValueInterpreter
 * @package Jpietrzyk\UsageStatistics\Collection
 */
interface ValueInterpreter
{
    /**
     * @param string $value
     * @return string
     */
    public function getRealValue($value);
}
