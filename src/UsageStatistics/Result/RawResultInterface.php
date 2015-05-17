<?php
namespace Jpietrzyk\UsageStatistics\Result;

interface RawResultInterface
{
    /**
     * @param RawResultItemInterface $resultItem
     */
    public function addResultItem(RawResultItemInterface $resultItem);

    /**
     * @param RawListCollectionInterface $list
     */
    public function addListCollection(RawListCollectionInterface $list);

    /**
     * @return int
     */
    public function getValidCount();

    /**
     * @return int
     */
    public function getInvalidCount();

    /**
     * @return RawResultItem[]
     */
    public function getResultItems();
}
