<?php


namespace Jpietrzyk\UsageStatistics\Handler\Init;


interface PackageDataLoader {

    /**
     * @param $packageName
     * @return array
     */
    public function getPackageData($packageName);

}