<?php


namespace Jpietrzyk\UsageStatistics;
use Jpietrzyk\UsageStatistics\Result\RawList;
use Jpietrzyk\UsageStatistics\Result\RawListCollection;
use Jpietrzyk\UsageStatistics\Result\RawListItem;

/**
 * Class ListCollector
 *
 * Collect lists for a certain counter
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class ListCollector
{

    /**
     * @var string
     */
    private $pathToSavableValue;

    /**
     * @var string
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
     * @return RawListCollection
     */
    public function getRawResult()
    {
        $ret = new RawListCollection($this->getPathToCompareValue());

        foreach($this->collectedData as $listName => $list) {
            $listResult = new RawList($listName);

            foreach($list as $name => $value) {
                $listResult->addItem(new RawListItem($name, $value));
            }

            $ret->addList($listResult);
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function getPathToCompareValue() {
        return $this->pathToComparableValue;
    }
}
