<?php


namespace Jpietrzyk\UsageStatistics\Handler\Init;


class RawPackage {

    /**
     * @var string
     */
    private $name;

    /**
     * @var data
     */
    private $data;

    /**
     * @param $name
     * @param array $data
     */
    public function __construct($name, array $data) {
        $this->name = (string) $name;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return data
     */
    public function getData()
    {
        return $this->data;
    }
}