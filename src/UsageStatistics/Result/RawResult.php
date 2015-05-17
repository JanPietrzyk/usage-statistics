<?php


namespace Jpietrzyk\UsageStatistics\Result;

class RawResult implements RawResultInterface
{

    /**
     * @var int
     */
    private $packageCount;

    /**
     * @var int
     */
    private $invalidCount;

    /**
     * @var RawResultItemInterface[]
     */
    private $resultItems = [];

    /**
     * @var RawListInterface[]
     */
    private $lists = [];

    /**
     * @param $packageCount
     * @param $invalidCount
     */
    public function __construct($packageCount, $invalidCount)
    {
        $this->packageCount = (int) $packageCount;
        $this->invalidCount = (int) $invalidCount;
    }

    /**
     * @param RawResultItemInterface $resultItem
     */
    public function addResultItem(RawResultItemInterface $resultItem)
    {
        $this->resultItems[] = $resultItem;
    }

    /**
     * @param RawListCollectionInterface $list
     */
    public function addListCollection(RawListCollectionInterface $list)
    {
        $this->lists[] = $list;
    }

    /**
     * @return int
     */
    public function getPackageCount()
    {
        return $this->packageCount;
    }

    /**
     * @return int
     */
    public function getValidCount()
    {
        $ret = 0;

        foreach ($this->resultItems as $item) {
            $ret += $item->getNumberOfOccurrences();
        }

        return $ret;
    }

    /**
     * @return int
     */
    public function getInvalidCount()
    {
        return $this->invalidCount;
    }

    /**
     * @return RawResultItem[]
     */
    public function getResultItems()
    {
        return $this->resultItems;
    }
}
