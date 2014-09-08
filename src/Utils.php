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

    public static function comparePhrase($phrase1, $phrase2)
    {
        $phrase1 = preg_replace("#[^a-zа-яёЁ]+#uis", "", $phrase1);
        $phrase2 = preg_replace("#[^a-zа-яёЁ]+#uis", "", $phrase2);
        $encoding = 'UTF-8';

        $wordInPhrase1 = mb_strtolower($phrase1, $encoding);
        $wordInPhrase2 = mb_strtolower($phrase2, $encoding);

        $matrix = array(
            'а' => 0,  'б' => 0,  'в' => 0,  'г' => 0,  'д' => 0,  'е' => 0,  'ё' => 0,  'ж' => 0,  'з' => 0,  'и' => 0,
            'й' => 0,  'к' => 0,  'л' => 0,  'м' => 0,  'н' => 0,  'о' => 0,  'п' => 0,  'р' => 0,  'с' => 0,  'т' => 0,
            'у' => 0,  'ф' => 0,  'х' => 0,  'ц' => 0,  'ч' => 0,  'ш' => 0,  'щ' => 0,  'ь' => 0,  'ы' => 0,  'ъ' => 0,
            'э' => 0,  'ю' => 0,  'я' => 0,

            'a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0, 'f' => 0, 'g' => 0, 'h' => 0, 'i' => 0, 'j' => 0, 'k' => 0,
            'l' => 0, 'm' => 0, 'n' => 0, 'o' => 0, 'p' => 0, 'q' => 0, 'r' => 0, 's' => 0, 't' => 0, 'u' => 0, 'v' => 0,
            'w' => 0, 'x' => 0, 'y' => 0, 'z' => 0,
        );

        $matrix1 = array();
        $matrix2 = array();
        foreach ($matrix as $wordKey => $temp) {

            list(, $ord) = unpack('N', mb_convert_encoding($wordKey, 'UCS-4BE', 'UTF-8'));

            $matrix1[$ord] = 0;
            $matrix2[$ord] = 0;
        }

        for ($i = 0; $i < mb_strlen($wordInPhrase1, $encoding); $i++) {
            $word = mb_substr($wordInPhrase1, $i, 1, $encoding);
            list(, $ord) = unpack('N', mb_convert_encoding($word, 'UCS-4BE', 'UTF-8'));
            $matrix1[$ord]++;
        }

        for ($i = 0; $i < mb_strlen($wordInPhrase2, $encoding); $i++) {
            $word = mb_substr($wordInPhrase2, $i, 1, $encoding);
            list(, $ord) = unpack('N', mb_convert_encoding($word, 'UCS-4BE', 'UTF-8'));
            $matrix2[$ord]++;
        }

        $matchPercent = 0;
        $matchWordPercent = 100 / count($matrix);

        foreach ($matrix1 as $matrixKey => $matrixValue) {
            if (($matrix1[$matrixKey] == 0 && $matrix2[$matrixKey] == 0) || ($matrix1[$matrixKey] == $matrix2[$matrixKey])) {
                $matchPercent += $matchWordPercent;
            } else {
                $maxWord = max($matrix1[$matrixKey], $matrix2[$matrixKey]);
                $minWord = min($matrix1[$matrixKey], $matrix2[$matrixKey]);
                $matchPercent += ($matchWordPercent * ($minWord / $maxWord));
            }

        }

        return round($matchPercent, 2);
    }

}