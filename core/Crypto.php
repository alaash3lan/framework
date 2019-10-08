<?php
namespace Core;

class Crypto 
{ 

    /**
     * The cipher method
     */
    const CIPHER = "aes-256-gcm";

    /**
     * The length of the authentication tag.
     */
    const TAG_LENGTH = 16;


    /**
     * encript a string with key 
     *
     * @param [string] $textToEncrypt
     * @param [string] $pass
     * @return string
     */
    public static function encript($textToEncrypt,string $password):string
    {   
        $key = self::key($password);
        $iv = self::iv();  
        $tag = ""; // will be filled by openssl_encrypt
        $ciphertext = openssl_encrypt($textToEncrypt, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag, "", self::TAG_LENGTH);
        return self::encode($iv.$tag.$ciphertext);
    }


    /**
     * Generates a string of pseudo-random bytes
     * @return string
     */
    private function iv():string
    {
        $ivLen = openssl_cipher_iv_length(self::CIPHER);
        return openssl_random_pseudo_bytes($ivLen);
    }


    /**
     * generate hashed key 
     * @param string $password
     * @return string
     */
    private function key(string $password):string
    {
        return substr(hash('sha256', $password, true), 0, 32);
    }


    /**
     * Encodes data with MIME base64
     *
     * @param string $string
     * @return string
     */
    private function encode(string $string):string
    {
        return  base64_encode($string);
    }


    /**
     * Decodes data with MIME base64 
     *
     * @param string $string
     * @return string
     */
    private function decode(string $string):string
    {
        return  base64_decode($string);
    }

    /**
     * decript a string 
     *
     * @param [string] $textToDecrypt
     * @param [string] $password
     * @return string
     */
    public function decript(string $textToDecrypt,string $password):string 
    {
        $encrypted = self::decode($textToDecrypt);
        $key = self::key($password);
        $iv_len = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($encrypted, 0, $iv_len);
        $tag = substr($encrypted, $iv_len, self::TAG_LENGTH);
        $ciphertext = substr($encrypted, $iv_len + self::TAG_LENGTH) ;
        return  openssl_decrypt($ciphertext, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag);
        
    }
}

$pass = "alaa";
$c =  Crypto::encript("i'm here",$pass);
print Crypto::decript($c,"alaa");


