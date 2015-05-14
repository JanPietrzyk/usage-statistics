<?php


namespace Jpietrzyk\UsageStatisticsTest\Collection;

use Jpietrzyk\UsageStatistics\ArrayPathFinder;
use Jpietrzyk\UsageStatistics\Validator\ItemValidator;

class ItemValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testWithoutValue()
    {
        $iv = new ItemValidator('test.is_it_set');

        $this->assertTrue($iv->isValid(new ArrayPathFinder([
            'test' => [
                'is_it_set' => true
            ]
        ])));

        $this->assertTrue($iv->isValid(new ArrayPathFinder([
            'test' => [
                'is_it_set' => false
            ]
        ])));

        $this->assertTrue($iv->isValid(new ArrayPathFinder([
            'test' => [
                'is_it_set' => null
            ]
        ])));
        $this->assertFalse($iv->isValid(new ArrayPathFinder([
            'test' => [
            ]
        ])));
        $this->assertFalse($iv->isValid(new ArrayPathFinder([

        ])));
    }

    public function testWithValue()
    {
        $iv = new ItemValidator('test.is_it_set', 'juhu');

        $this->assertTrue($iv->isValid(new ArrayPathFinder([
             'test' => [
                 'is_it_set' => 'juhu'
             ]
         ])));

        $iv = new ItemValidator('test.is_it_set', true);
        $this->assertTrue($iv->isValid(new ArrayPathFinder([
             'test' => [
                 'is_it_set' => true
             ]
         ])));

        $iv = new ItemValidator('test.is_it_set', false);
        $this->assertTrue($iv->isValid(new ArrayPathFinder([
             'test' => [
                 'is_it_set' => false
             ]
         ])));
    }
}
