<?php

namespace App;

use Monolog;

class ImageThumb
{
    function create($imagePath, $size = 200) {
        $imagick = new \Imagick($imagePath);
        $imagick->thumbnailImage($size, 0);
        $imagePathThumb = $imagePath . '-thumb';
        $file = fopen($imagePathThumb, "w");
        fclose($file);
        $imagick->writeImage( $imagePathThumb );
    }

}