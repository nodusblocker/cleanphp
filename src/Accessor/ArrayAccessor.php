<?php

namespace NodusBlocker\CleanPhp\Accessor;

class ArrayAccessor
{
    public function __construct($keySeparator = '.')
    {
        $this->keySeparator = $keySeparator;
    }

    public function get(&$array, $key, $default = null)
    {
        if (!is_array($array)) {
            return $default;
        }
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        if (!is_string($key)) {
            return $default;
        }

        $keyParts = explode($this->keySeparator, $key);

        if (count($keyParts) === 1) {
            return $default;
        }

        foreach ($keyParts as $keyPart) {
            if (
                !is_array($array) ||
                !array_key_exists($keyPart, $array)
            ) {
                return $default;
            }
            $array = &$array[$keyPart];
        }

        return $array;

    }

    public function set(&$array, $key, $value)
    {
        $array = is_array($array) ? $array : [];

        if (!is_string($key)) {
            $array[$key] = $value;
            return;
        }

        $keyParts  = explode($this->keySeparator, $key);
        $lastIndex = count($keyParts) - 1;

        foreach ($keyParts as $index => $keyPart) {
            if (
                $index !== $lastIndex &&
                (
                    !array_key_exists($keyPart, $array) ||
                    !is_array($array[$keyPart])
                )
            ) {
                $array[$keyPart] = [];
            }
            if ($index === $lastIndex) {
                $array[$keyPart] = $value;
            }
            $array = &$array[$keyPart];
        }
    }

    public function has(&$array, $key)
    {
        if (!is_array($array)) {
            return false;
        }
        if (array_key_exists($key, $array)) {
            return true;
        }
        if (!is_string($key)) {
            return false;
        }

        $keyParts = explode($this->keySeparator, $key);

        if (count($keyParts) === 1) {
            return false;
        }

        foreach ($keyParts as $keyPart) {
            if (
                !is_array($array) ||
                !array_key_exists($keyPart, $array)
            ) {
                return false;
            }
            $array = &$array[$keyPart];
        }

        return true;
    }

    public function remove(&$array, $key)
    {
        if (!is_array($array)) {
            return;
        }
        if (array_key_exists($key, $array)) {
            unset($array[$key]);
            return;
        }
        if (!is_string($key)) {
            return;
        }

        $keyParts  = explode($this->keySeparator, $key);
        $lastIndex = count($keyParts) - 1;

        foreach ($keyParts as $index => $keyPart) {
            if (
                !is_array($array) ||
                !array_key_exists($keyPart, $array)
            ) {
                return;
            }
            if ($index === $lastIndex) {
                unset($array[$keyPart]);
                return;
            }
            $array = &$array[$keyPart];
        }

    }

    public function replace(&$array, $newArray = [])
    {
        if (!is_array($newArray)) {
            $newArray = [];
        }

        $array = $newArray;
    }

    public function update(&$array, $key, $value)
    {
        if (!is_array($value)) {
            return $this->set($array, $key, $value);
        }

        $oldValue = $this->get($array, $key);

        if (!is_array($oldValue)) {
            return $this->set($array, $key, $value);
        }

        $value = array_replace_recursive(
            $array, $oldValue, $value
        );

        return $this->set($key, $value);

    }
}
