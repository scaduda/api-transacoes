<?php

declare(strict_types=1);

namespace App\Utils\Traits;

trait Mapping
{
    /**
     * @param array $data
     * @param string ...$keys
     * @return string
     */
    private static function getString(array $data, ...$keys): string
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return (string)$data[$key];
            }
        }
        return '';
    }

    /**
     * @param array $data
     * @param string ...$keys
     * @return float
     */
    private static function getFloat(array $data, ...$keys): float
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return (float)$data[$key];
            }
        }
        return 0;
    }

    /**
     * @param array $data
     * @param string ...$keys
     * @return int
     */
    private static function getInt(array $data, ...$keys): int
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return (int)$data[$key];
            }
        }
        return 0;
    }

}
