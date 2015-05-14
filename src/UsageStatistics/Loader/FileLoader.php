<?php


namespace Jpietrzyk\UsageStatistics\Loader;

/**
 * Class FileLoader
 *
 * Load packagist data from files
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class FileLoader implements LoaderInterface
{

    private $fileNames = [];

    private $directory;

    /**
     * @param $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->loadFileNames();
    }

    /**
     * @return callable
     */
    public function getGenerator()
    {
        return function () {
            foreach ($this->fileNames as $fileName) {
                yield $this->loadItem($fileName);
            }
        };
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getData($offset, $limit)
    {
        $names = array_slice($this->fileNames, $offset, $limit);

        $ret = [];
        foreach ($names as $fileName) {
            $ret[] = eval('return ' . file_get_contents($this->directory . '/' . $fileName) . ';');
        }

        return $ret;
    }

    private function loadItem($fileName)
    {
        return eval('return ' . file_get_contents($this->directory . '/' . $fileName) . ';');
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return count($this->fileNames);
    }

    /**
     *
     */
    private function loadFileNames()
    {
        foreach (scandir($this->directory) as $packageName) {
            if ($packageName == '.' || $packageName == '..') {
                continue;
            }

            $this->fileNames[] = $packageName;
        }
    }
}
