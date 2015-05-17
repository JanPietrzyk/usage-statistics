<?php


namespace Jpietrzyk\UsageStatistics\Result;


class RawList implements RawListInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var RawListItemInterface[]
     */
    private $items = [] ;

    public function __construct($name) {
        $this->name = (string) $name;
    }

    /**
     * @param RawListItemInterface $listItem
     */
    public function addItem(RawListItemInterface $listItem) {
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
     * @return RawListItemInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }
}