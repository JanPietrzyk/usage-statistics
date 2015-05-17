<?php


namespace Jpietrzyk\UsageStatistics\Calculator;


class Precision {

    /**
     * @var int
     */
    private $precision;

    /**
     * @param $precision
     */
    public function __construct($precision) {
        $this->precision = (int) $precision;
    }

    /**
     * @return int
     */
    public function getPrecision() {
        return $this->precision;
    }

    /**
     * @param float $value
     * @return string
     */
    public function formatValue($value) {
        return number_format($value, $this->precision);
    }

}