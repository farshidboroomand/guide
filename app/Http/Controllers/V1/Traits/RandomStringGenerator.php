<?php
/**
 * Created by PhpStorm.
 * User: saeed
 * Date: 9/2/19
 * Time: 7:37 PM
 */

namespace App\Http\Controllers\V1\Traits;


class RandomStringGenerator
{
    public function execute($len = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        for ($i = 0; $i < $len; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $code;
    }
}