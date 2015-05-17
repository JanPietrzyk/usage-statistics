<?php


namespace Jpietrzyk\UsageStatistics;

/**
 * Class ArrayPathFinder
 *
 * Get array values from path strings like x.y.z
 *
 * @package Jpietrzyk\UsageStatistics\Collection
 */
class ArrayPathFinder implements PathFinder
{
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param $path
     * @return bool
     */
    public function has($path)
    {
        try {
            $this->requireValue($path);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $path
     * @param null $default
     * @return array|null
     */
    public function getValue($path, $default = null)
    {
        try {
            $value = $this->requireValue(
                $path
            );
        } catch (\InvalidArgumentException $e) {
            return $default;
        }

        return $value;
    }

    /**
     * @param $path
     * @return mixed
     */
    public function requireValue($path)
    {
        $pathParts = $this->splitPath($path);
        $current = $this->data;

        foreach ($pathParts as $key) {
            if (!is_array($current)) {
                throw new \InvalidArgumentException('Path not found');
            }

            $current = $this->findValue($key, $current);
        }

        return $current;
    }

    /**
     * @param $key
     * @param $current
     * @return mixed
     */
    private function findValue($key, $current)
    {
        $value = $this->findValueWithWildcard($key, $current);

        if ($value) {
            return $value;
        }

        if (!array_key_exists($key, $current)) {
            throw new \InvalidArgumentException($key . ' not part of array');
        }

        return $current[$key];
    }

    private function findValueWithWildcard($key, $current)
    {
        if (strpos($key, self::WILDCARD) !== strlen($key) - 1) {
            return false;
        }

        $key = substr($key, 0, strlen($key) - 1);

        foreach (array_keys($current) as $possibleKey) {
            if (0 === strpos($possibleKey, $key)) {
                return $current[$possibleKey];
            }
        }

        throw new \InvalidArgumentException('Nothing like "' . $key . '" found in array');
    }

    /**
     * @param $path
     * @return array
     */
    private function splitPath($path)
    {
        return explode('.', $path);
    }

    public function __toString()
    {
        return var_export($this->data, true);
    }
}
