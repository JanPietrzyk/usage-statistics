<?php
namespace Jpietrzyk\UsageStatistics\Result;

interface RawListItemInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();
}