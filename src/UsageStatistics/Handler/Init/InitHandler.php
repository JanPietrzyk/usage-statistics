<?php


namespace Jpietrzyk\UsageStatistics\Handler\Init;

use Jpietrzyk\UsageStatistics\Handler\MessageResponse;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InitHandler
 *
 * @todo replace file handling functionality with clear interface
 *
 * @package Jpietrzyk\UsageStatistics
 */
class InitHandler
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var int
     */
    private $cnt = 0;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @param $path
     * @param $totalCount
     */
    public function __construct($path, $totalCount)
    {
        $this->path = (string) $path;
        $this->totalCount = (int) $totalCount;

        $this->preparePath();
    }

    /**
     * @param RawPackage $package
     * @return MessageResponse
     */
    public function addPackage(RawPackage $package)
    {
        $response = new MessageResponse();
        $this->writePackages($package, $response);
        return $response;
    }


    private function preparePath()
    {
        $this->checkPathExists();
        $this->removePathContents();
    }

    private function checkPathExists()
    {
        if (is_dir($this->path)) {
            return;
        }

        $success = mkdir($this->path);

        if (false === $success) {
            throw new \RuntimeException('Unable to create "' . $this->path . '"');
        }
    }

    private function removePathContents()
    {
        foreach (scandir($this->path) as $fileName) {
            if ($fileName == '.' || $fileName == '..') {
                continue;
            }

            $file = $this->path . '/' . $fileName;

            $success = unlink($file);

            if (!$success) {
                throw new \RuntimeException('Unable to remove "' . $file . '"');
            }
        }
    }

    /**
     * @param RawPackage $package
     * @param MessageResponse $response
     */
    private function writePackages(RawPackage $package, MessageResponse $response)
    {
        $response->addMessage('Storing ' . $package->getName());
        $this->writeContents($package);
        $this->updateCounterAndSleep($response);
    }

    /**
     * @param RawPackage $package
     */
    private function writeContents(RawPackage $package)
    {
        $success = file_put_contents(
            $this->path . '/' . str_replace('/', '___', $package->getName()) . '.cache',
            var_export($package->getData(), true)
        );

        if (false === $success) {
            throw new \RuntimeException('Unable to write "' . $package->getName() . '"');
        }
    }


    /**
     * @param MessageResponse $response
     */
    private function updateCounterAndSleep(MessageResponse $response)
    {
        $this->cnt++;

        if (0 == ($this->cnt % 200)) {
            $response->addMessage($this->cnt . ' of ' . $this->totalCount);
            $response->addMessage('--sleeping--');
        }

        if (1 == ($this->cnt % 200)) {
            sleep(20);
        }
    }
}
