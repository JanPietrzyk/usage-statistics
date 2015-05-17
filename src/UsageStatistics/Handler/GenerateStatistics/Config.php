<?php


namespace Jpietrzyk\UsageStatistics\Handler\GenerateStatistics;


use Jpietrzyk\UsageStatistics\Counter;
use Jpietrzyk\UsageStatistics\Loader\LoaderInterface;
use Jpietrzyk\UsageStatistics\StatisticGenerator;

class Config {

    /**
     * @var StatisticGenerator[]
     */
    private $generators = [];

    /**
     * @var LoaderInterface
     */
    private $loader;

    /**
     * @param LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader) {
        $this->loader = $loader;
    }

    /**
     * @param StatisticGenerator $generator
     */
    public function addGenerator(StatisticGenerator $generator) {
        $this->generators[] = $generator;
    }

    /**
     * @return StatisticGenerator[]
     */
    public function getGenerators()
    {
        return $this->generators;
    }

    /**
     * @return LoaderInterface
     */
    public function getLoader()
    {
        return $this->loader;
    }
}