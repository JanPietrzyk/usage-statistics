<?php

namespace Jpietrzyk\UsageStatisticsTest;

use Jpietrzyk\UsageStatistics\Counter\ArrayCounter;
use Jpietrzyk\UsageStatistics\Counter\ArrayKeyCounter;
use Jpietrzyk\UsageStatistics\Counter\ResultSet;
use Jpietrzyk\UsageStatistics\Counter\ScalarValueCounter;
use Jpietrzyk\UsageStatistics\PathFinder;
use Jpietrzyk\UsageStatistics\ValueInterpreter\ValueInterpreter;

class CounterTest extends \PHPUnit_Framework_TestCase{

    private $arrayCounterFixtures = [
        ['a', 'b'],
        ['b'],
        ['b', 'c']
    ];

    public function testArrayCounter() {
        $counter = new ArrayCounter('test');
        $resultSet = new ResultSet();
        $mockPathFinder = new MockPathFinder();

        foreach($this->arrayCounterFixtures as $value) {
            $mockPathFinder->value = $value;
            $counter->inspect($mockPathFinder, $resultSet);


            $this->assertEquals($value, $resultSet->getModified());
            $resultSet->resetModified();
        }

        $this->assertEquals(0, $resultSet->getInvalidCount());
        $this->assertArrayHasKey('a', $resultSet->getValues());
        $this->assertArrayHasKey('b', $resultSet->getValues());
        $this->assertArrayHasKey('c', $resultSet->getValues());
        $this->assertEquals(1, $resultSet->getValues()['a']);
        $this->assertEquals(3, $resultSet->getValues()['b']);
        $this->assertEquals(1, $resultSet->getValues()['c']);
    }

    private $arrayKeyCounterFixtures = [
        [
            'a' => 0,
            'b' => 0,
        ],
        [
            'b' => 0,
        ],
        [
            'b' => 0,
            'c' => 0,
        ],
    ];

    public function testArrayKeyCounter() {
        $counter = new ArrayKeyCounter('test', new MockValueInterpreter());
        $resultSet = new ResultSet();
        $mockPathFinder = new MockPathFinder();

        foreach($this->arrayKeyCounterFixtures as $value) {
            $mockPathFinder->value = $value;
            $counter->inspect($mockPathFinder, $resultSet);


            $this->assertEquals(array_keys($value), $resultSet->getModified());
            $resultSet->resetModified();
        }

        $this->assertEquals(0, $resultSet->getInvalidCount());
        $this->assertArrayHasKey('a', $resultSet->getValues());
        $this->assertArrayHasKey('b', $resultSet->getValues());
        $this->assertArrayHasKey('c', $resultSet->getValues());
        $this->assertEquals(1, $resultSet->getValues()['a']);
        $this->assertEquals(3, $resultSet->getValues()['b']);
        $this->assertEquals(1, $resultSet->getValues()['c']);
    }

    private $scalarValueCounterFixtures = [
        'a',
        'b',
        'b',
        'b',
        'c',
    ];

    public function testScalarCounter() {
        $counter = new ScalarValueCounter('test', new MockValueInterpreter());
        $resultSet = new ResultSet();
        $mockPathFinder = new MockPathFinder();

        foreach($this->scalarValueCounterFixtures as $value) {
            $mockPathFinder->value = $value;
            $counter->inspect($mockPathFinder, $resultSet);


            $this->assertEquals([$value], $resultSet->getModified());
            $resultSet->resetModified();
        }

        $this->assertEquals(0, $resultSet->getInvalidCount());
        $this->assertArrayHasKey('a', $resultSet->getValues());
        $this->assertArrayHasKey('b', $resultSet->getValues());
        $this->assertArrayHasKey('c', $resultSet->getValues());
        $this->assertEquals(1, $resultSet->getValues()['a']);
        $this->assertEquals(3, $resultSet->getValues()['b']);
        $this->assertEquals(1, $resultSet->getValues()['c']);
    }

}

class MockPathFinder implements PathFinder {

    public $value;

    /**
     * @param $path
     * @return bool
     */
    public function has($path)
    {
        return (bool) $this->value;
    }

    /**
     * @param $path
     * @param null $default
     * @return array|null
     */
    public function getValue($path, $default = null)
    {
        return $this->value;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function requireValue($path)
    {
        if($this->value) {
            return $this->value;
        }

        throw new \InvalidArgumentException('');
    }
}

class MockValueInterpreter implements ValueInterpreter {

    /**
     * @param string $value
     * @return string
     */
    public function getRealValue($value)
    {
        return $value;
    }
}