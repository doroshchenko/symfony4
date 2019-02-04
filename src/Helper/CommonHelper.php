<?php

namespace App\Helper;

class CommonHelper
{
    const CRYPT_METHOD = 'AES-128-ECB';

    /**
     * @return string
     */
    public static function generateHash() : string
    {
        return md5(time() . rand());
    }

    public static function encrypt(string $string, $salt = NULL) : string
    {
        $encoded = openssl_encrypt($string,self::CRYPT_METHOD, $salt);

        return $encoded;
    }

    public static function decrypt(string $hash, $salt = NULL) : string
    {
        $decoded = openssl_decrypt($hash,self::CRYPT_METHOD, $salt);

        return $decoded;
    }
}