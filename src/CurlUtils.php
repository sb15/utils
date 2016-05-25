<?php

namespace Sb;

class CurlUtils
{
    public static function getUrl($url)
    {
        $ch = curl_init();
        if (!$ch) {
            throw new \RuntimeException('cURL init error');
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:46.0) Gecko/20100101 Firefox/46.0');

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException('Connection error to '. $url . ' Return code: ' . $httpCode . ' Message: ' . $error);
        }

        curl_close($ch);
        return $response;
    }
}