<?php

namespace Sb;

class Utils
{
    public static function getNameMany($name)
    {
        $result = $name;
        $lastWord = substr($name, -1, 1);

        switch ($lastWord) {
            case 's':
                $result .= 'es';
                break;
            case 'y':
                $result = substr($result, 0, strlen($result) - 1) . 'ies';
                break;
            default:
                $result .= 's';
        }
        return $result;
    }

    public static function wordUnderscoreToCamelCase($value)
    {
        $separator = '_';
        $isUnicodeSupportEnabled = (@preg_match('/\pL/u', 'a')) ? true : false;

        $pregQuotedSeparator = preg_quote($separator, '#');

        if ($isUnicodeSupportEnabled) {
            $matchPattern = array('#('.$pregQuotedSeparator.')(\p{L}{1})#e','#(^\p{Ll}{1})#e');
            $replacement = array("strtoupper('\\2')","strtoupper('\\1')");
        } else {
            $matchPattern = array('#('.$pregQuotedSeparator.')([A-Za-z]{1})#e','#(^[A-Za-z]{1})#e');
            $replacement = array("strtoupper('\\2')","strtoupper('\\1')");
        }

        return preg_replace($matchPattern, $replacement, $value);
    }

    public static function wordUnderscoreToCamelCaseFirstLower($value)
    {
        return lcfirst(self::wordUnderscoreToCamelCase($value));
    }

}