<?php


namespace Jpietrzyk\UsageStatistics\Result;

use Jpietrzyk\UsageStatistics\Calculator\Precision;

/**
 * Class ResultItem
 * @package Jpietrzyk\UsageStatistics\Calculator
 */
class CalculatedResultItem extends RawResultItem implements ResultItemInterface
{

    /**
     * @var float
     */
    private $percentage;

    /**
     * @param float $percentage
     * @param Precision $precision
     * @param RawResultItem $item
     */
    public function __construct($percentage, Precision $precision, RawResultItem $item)
    {
        parent::__construct($item->getName(), $item->getNumberOfOccurrences());

        $this->precision = $precision;
        $this->percentage = (float) $percentage;
    }

    /**
     * @return float
     */
    public function getRawPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return string
     */
    public function getPercentage()
    {
        $percentage = round($this->percentage, $this->precision->getPrecision());

        return $this->precision->formatValue($percentage);
    }
}
