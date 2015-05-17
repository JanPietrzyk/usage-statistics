<?php


namespace Jpietrzyk\UsageStatisticsTest;


use Jpietrzyk\UsageStatistics\Calculator\Calculator;
use Jpietrzyk\UsageStatistics\Calculator\Precision;
use Jpietrzyk\UsageStatistics\Result\RawResult;

class CalculatorTest extends \PHPUnit_Framework_TestCase {

    public function testEmpty() {
        $calculator = new Calculator(new RawResult(0, 0), new Precision(2));

        $this->assertEquals(0, $calculator->getValidCount());
        $this->assertEquals(0, $calculator->getInvalidCount());
        $this->assertEquals([], $calculator->getResult());
    }

}