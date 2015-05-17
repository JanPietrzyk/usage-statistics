<?php


namespace Jpietrzyk\UsageStatistics\Result;


class RawResult implements RawResultInterface
{

    /**
     * @var int
     */
    private $totalCount;

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
     * @param $totalCount
     * @param $invalidCount
     */
    public function __construct($totalCount, $invalidCount) {
        $this->totalCount = (int) $totalCount;
        $this->invalidCount = (int) $invalidCount;
    }

    /**
     * @param RawResultItemInterface $resultItem
     */
    public function addResultItem(RawResultItemInterface $resultItem) {
        $this->resultItems[] = $resultItem;
    }

    /**
     * @param RawListCollectionInterface $list
     */
    public function addListCollection(RawListCollectionInterface $list) {
        $this->lists[] = $list;
    }

    /**
     * @return int
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getInvalidCount() {
        return $this->invalidCount;
    }

    /**
     * @return RawResultItem[]
     */
    public function getResultItems() {
        return $this->resultItems;
    }
}