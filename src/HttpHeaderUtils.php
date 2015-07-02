<?php

namespace Sb;

class HttpHeaderUtils
{
    public static function parseToArray($header)
    {
        $result = [];
        $header = explode("\n", $header);
        foreach ($header as $headerLine) {
            $headerLine = trim($headerLine);
            if (strpos($headerLine, ":") !== 0) {
                $temp = explode(":", $headerLine, 2);
                if (count($temp) == 2) {
                    $result[$temp[0]] = trim($temp[1]);
                }
            }
        }
        return $result;
    }
}