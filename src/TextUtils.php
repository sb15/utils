<?php

namespace Sb;

class TextUtils
{
    public static function transliterate($text, $encoding = 'UTF-8')
    {
        $from = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т',
            'У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё',
            'ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ',
            'ъ','ы','ь','э','ю','я');

        if ($encoding != 'UTF-8') {
            foreach ($from as &$word) {
                $word = iconv('UTF-8', $encoding, $word);
            }
        }

        $to   = array('A','B','V','G','D','E','E','J','Z','I','I','K','L','M','N','O','P','R','S','T',
            'U','F','H','C','Ch','Sh','Sch','\'','Y','\'','E','Yu','Ya','a','b','v','g','d',
            'e','e','j','z','i','i','k','l','m','n','o','p','r','s','t','u','f','h','c','ch',
            'sh','sch','\'','y','\'','e','yu','ya');
        return str_replace($from, $to, $text);
    }
    
    public static function getShortDescription($description, $limit = 3)
    {
        $descriptionArray = explode(".", trim(strip_tags($description)));
        $descriptionShort = array();
        for ($i = 0; $i <= $limit - 1; $i++) {
            if (isset($descriptionArray[$i])) {
                $descriptionShort[] = $descriptionArray[$i];
            }
        }
        $descriptionShortText = implode(".", $descriptionShort);
        if ($descriptionShortText) {
            $descriptionShortText .= '.';
            $descriptionShortText = trim($descriptionShortText);
        }
        return $descriptionShortText;
    }

    public static function toJsUnicode($text)
    {
        $output = "";
        $utf16 = mb_convert_encoding($text, 'UTF-16BE');
        for ($i= 0; $i < strlen($utf16); $i+= 2) {
            $output.= '\\u'.str_pad(dechex((ord($utf16{$i}) << 8) + ord($utf16{$i+1})), 4, '0', STR_PAD_LEFT);
        }
        return $output;
    }

    public static function trim($value)
    {
        $value = str_replace(" ", " ", $value);
        $value = trim($value);
        return $value;
    }
}