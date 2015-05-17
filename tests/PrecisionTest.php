<?php


namespace Jpietrzyk\UsageStatisticsTest;


use Jpietrzyk\UsageStatistics\Calculator\Precision;

class PrecisionTest extends \PHPUnit_Framework_TestCase {

    public function testFormatting() {
        $precision = new Precision(2);

        $this->assertTrue('2.00' === $precision->formatValue(2));
        $this->assertTrue('2.00' === $precision->formatValue(2.0));
        $this->assertTrue('2.11' === $precision->formatValue(2.1111111));
        $this->assertTrue('2.67' === $precision->formatValue(2.6666666));
        $this->assertTrue('2.56' === $precision->formatValue(2.5555555));
    }
}