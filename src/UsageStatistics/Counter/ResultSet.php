<?php


namespace Jpietrzyk\UsageStatistics\Counter;

/**
 * Class ResultSet
 * @package Jpietrzyk\UsageStatistics\Counter
 */
class ResultSet {

    /**
     * If the given path was not found in array
     */
    const NOT_FOUND_KEY = '_NOT_FOUND_';

    /**
     * @var array
     */
    private $values = [
        self::NOT_FOUND_KEY => 0
    ];

    /**
     * @var int
     */
    private $totalCount = 0;

    /**
     * @var int
     */
    private $invalidCount = 0;

    /**
     * @var array
     */
    private $modified = [];

    /**
     * @param $filteredValue
     */
    public function incValue($filteredValue)
    {

        if (!isset($this->values[$filteredValue])) {
            $this->values[$filteredValue] = 0;
        }

        $this->values[$filteredValue]++;

        $this->modified[] = $filteredValue;

        $this->totalCount++;
    }

    /**
     * add not found value
     */
    public function setNotFound()
    {
        $this->values[self::NOT_FOUND_KEY]++;
    }

    /**
     * set current item invalid
     */
    public function setInvalid()
    {
        $this->invalidCount++;
    }

    /**
     * @return array recently added fields
     */
    public function getModified() {
        return $this->modified;
    }

    /**
     * reset recently added fields
     */
    public function resetModified() {
        $this->modified = [];
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getInvalidCount()
    {
        return $this->invalidCount;
    }
}