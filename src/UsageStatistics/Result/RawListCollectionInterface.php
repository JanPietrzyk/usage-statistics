<?php
namespace Jpietrzyk\UsageStatistics\Result;

interface RawListCollectionInterface
{
    /**
     * @param RawListInterface $listItem
     */
    public function addList(RawListInterface $listItem);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return RawListInterface[]
     */
    public function getLists();
}
