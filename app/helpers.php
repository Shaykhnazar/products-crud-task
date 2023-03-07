<?php

if (!function_exists('snakeToCamelWords')) {
    /**
     * @example
     * Input: sku_setting
     * Output: SkuSetting
     * @param $string
     * @return string
     */
    function snakeToCamelWords($string): string
    {
        $newString = str_replace('_', ' ', $string);
        $newString = ucwords($newString);

        return str_replace(' ', '', $newString);
    }
}


if (!function_exists('validateLatin')) {
    /**
     * Check that given string only uses Latin characters, digits, and punctuation
     *
     * @param string|null $string $string String to validate
     * @return boolean True if Latin only, false otherwise
     */
    function validateLatin(?string $string): bool
    {
        if ($string && preg_match("/^[\w\d\s.,-]*$/", $string)) {
            return true;
        }

        return false;
    }
}