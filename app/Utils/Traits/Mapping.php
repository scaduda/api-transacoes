<?php

declare(strict_types = 1);

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

    private static function getFloat(array $data, ...$keys): float
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return (float)$data[$key];
            }
        }
        return 0;
    }

}
