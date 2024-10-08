<?php

function encrypt($any)
{
    $encrypter = \Config\Services::encrypter();

    return bin2hex($encrypter->encrypt($any));
   
}

function decrypt($any)
{
    $encrypter = \Config\Services::encrypter();

    return $encrypter->decrypt(hex2bin($any));
}
