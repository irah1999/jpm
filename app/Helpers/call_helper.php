<?php

function encryption($data)
{
    if ($data) {
        try {
            $encrypter = \Config\Services::encrypter();
            return base64_encode(base64_encode($encrypter->encrypt($data)));
        } catch (\Exception $e) {
            return $data;
        }
    }
}

function decryption($data)
{
    if ($data) {
        try {
            $encrypter = \Config\Services::encrypter();
            return $encrypter->decrypt(base64_decode(base64_decode($data)));
        } catch (\Exception $e) {
            return $data;
        }
    }
}