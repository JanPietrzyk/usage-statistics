<?php
namespace Jpietrzyk\UsageStatistics\Result;

interface RawListInterface
{
    /**
     * @param RawListItemInterface $listItem
     */
    public function addItem(RawListItemInterface $listItem);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return RawListItem[]
     */
    public function getItems();
}