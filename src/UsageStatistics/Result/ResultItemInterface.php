<?php
namespace Jpietrzyk\UsageStatistics\Result;

/**
 * Class ResultItem
 * @package Jpietrzyk\UsageStatistics\Calculator
 */
interface ResultItemInterface
{
    /**
     * @return float
     */
    public function getRawPercentage();

    /**
     * @return string
     */
    public function getPercentage();
}
