<?php

namespace Sb;

class ImageUtils
{
    public static function pad(\Imagine\Gd\Image $img, \Imagine\Image\Box $size, $fcolor=[255,255,255], $ftransparency = 0)
    {
        $tsize = $img->getSize();
        $x = $y = 0;
        if ($size->getWidth() > $tsize->getWidth()) {
            $x =  round(($size->getWidth() - $tsize->getWidth()) / 2);
        }
        if ($size->getHeight() > $tsize->getHeight()) {
            $y = round(($size->getHeight() - $tsize->getHeight()) / 2);
        }
        $pasteto = new \Imagine\Image\Point($x, $y);
        $imagine = new \Imagine\Gd\Imagine();
        $palette = new \Imagine\Image\Palette\RGB();
        $color = new \Imagine\Image\Palette\Color\RGB($palette, $fcolor, $ftransparency);
        $image = $imagine->create($size, $color);

        $image->paste($img, $pasteto);

        return $image;
    }

}