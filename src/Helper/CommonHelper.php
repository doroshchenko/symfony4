<?php

namespace App\Helper;

class CommonHelper
{
    /**
     * @return string
     */
    public static function generateHash() : string
    {
        return md5(time() . rand());
    }
}