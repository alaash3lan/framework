<?php
namespace Core;

class Crypto 
{ 
    public $key; 


    /**
     * encript a string with key 
     *
     * @param [string] $textToEncrypt
     * @param [string] $pass
     * @return string
     */
    public static function encript($textToEncrypt,string $pass)
    {   
      $key = substr(hash('sha256', $pass, true), 0, 32);
      $cipher = 'aes-256-gcm';
      $iv_len = openssl_cipher_iv_length($cipher);
      $tag_length = 16;
      $iv = openssl_random_pseudo_bytes($iv_len);
      $tag = ""; // will be filled by openssl_encrypt

     $ciphertext = openssl_encrypt($textToEncrypt, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, "", $tag_length);
     $encrypted = base64_encode($iv.$tag.$ciphertext);
     return $encrypted;
    }


    /**
     * Undocumented function
     *
     * @param [string] $textToDecrypt
     * @param [string] $password
     * @return string
     */
    public function decript(string $textToDecrypt,string $password)
    {
       
        $encrypted = base64_decode($textToDecrypt);
        $key = substr(hash('sha256', $password, true), 0, 32);
        $cipher = 'aes-256-gcm';
        $iv_len = openssl_cipher_iv_length($cipher);
        $tag_length = 16;
        $iv = substr($encrypted, 0, $iv_len);
        $tag = substr($encrypted, $iv_len, $tag_length);
        $ciphertext = substr($encrypted, $iv_len + $tag_length) ;
        return  openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
        
    }
}
