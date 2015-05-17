<?php


namespace Jpietrzyk\UsageStatistics\Result;


class RawListCollection implements RawListCollectionInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var RawListInterface[]
     */
    private $items;

    public function __construct($name) {
        $this->name = (string) $name;
    }

    /**
     * @param RawListInterface $listItem
     */
    public function addList(RawListInterface $listItem) {
        $this->items[] = $listItem;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return RawListInterface[]
     */
    public function getLists()
    {
        return $this->items;
    }
}