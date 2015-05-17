<?php


namespace Jpietrzyk\UsageStatisticsTest;


use Jpietrzyk\UsageStatistics\Calculator\Calculator;
use Jpietrzyk\UsageStatistics\Calculator\Precision;
use Jpietrzyk\UsageStatistics\Result\RawResult;

class CalculatorTest extends \PHPUnit_Framework_TestCase {

    public function testEmpty() {
        $calculator = new Calculator(new RawResult(0, 0), new Precision(2));

        $this->assertEquals(0, $calculator->getTotalCount());
        $this->assertEquals(0, $calculator->getInvalidPercentage());
        $this->assertEquals([], $calculator->getResult());
    }

    public function testInvalidPercentage() {
        $rawResult = new RawResult(1, 1);
        $calc = new Calculator($rawResult, new Precision(2));

        $this->assertTrue('100.00' === $calc->getInvalidPercentage(), $calc->getInvalidPercentage() . ' != 100.00');

        $rawResult = new RawResult(2, 1);
        $calc = new Calculator($rawResult, new Precision(2));

        $this->assertTrue('50.00' === $calc->getInvalidPercentage(), '!50.00');
    }


}