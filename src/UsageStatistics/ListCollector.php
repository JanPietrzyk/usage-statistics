<?php


namespace Jpietrzyk\UsageStatistics;

/**
 * Class ListCollector
 *
 * Collect lists for a cetrain counter
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class ListCollector
{

    /**
     * @var
     */
    private $pathToSavableValue;

    /**
     * @var
     */
    private $pathToComparableValue;

    /**
     * @var array
     */
    private $collectedData = [];

    /**
     * @var int
     */
    private $limit = 20;

    public function __construct($pathToSavableValue, $pathToComparableValue)
    {
        $this->pathToSavableValue = $pathToSavableValue;
        $this->pathToComparableValue = $pathToComparableValue;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = (int) $limit;

        return $this;
    }

    /**
     * @param $value
     * @param ArrayPathFinder $pathFinder
     * @return bool success status
     */
    public function inspectAs($value, ArrayPathFinder $pathFinder)
    {
        if (!$pathFinder->has($this->pathToComparableValue)) {
            throw new \RuntimeException('Could not find "' . $this->pathToComparableValue . '"');
        }

        if (!$pathFinder->has($this->pathToSavableValue)) {
            throw new \RuntimeException('Could not find "' . $this->pathToComparableValue . '"');
        }

        if (!isset($this->collectedData[$value])) {
            $this->collectedData[$value] = [];
        }

        $savableValue = $pathFinder->requireValue($this->pathToSavableValue);
        $comparableValue = $pathFinder->requireValue($this->pathToComparableValue);

        $this->store($this->collectedData[$value], $savableValue, $comparableValue);
    }

    /**
     * @param array $list
     * @param $title
     * @param $comparableValue
     */
    private function store(array &$list, $title, $comparableValue)
    {
        if ($this->limit > count($list)) {
            $list[$title] = $comparableValue;
            arsort($list);
            return;
        }

        $minValue = min($list);

        if ($minValue > $comparableValue) {
            return;
        }

        $index = array_search($minValue, $list);
        unset($list[$index]);
        $list[$title] = $comparableValue;
        arsort($list);
    }

    /**
     * @return array
     */
    public function getArrayResult()
    {
        return [$this->pathToComparableValue => $this->collectedData];
    }
}
