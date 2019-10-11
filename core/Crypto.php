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

    private $publicKey;

    public function __constrruct()
    {
        $this->creatKey();     
    }
    /**
     * encript a string with key 
     *
     * @param [string] $textToEncrypt
     * @param [string] $pass
     * @return string
     */
    public  function encript(string $value):string
    {  
        $value  =  json_encode($value);
        $key = $this->publicKey;
        $iv = $this->iv();  
        $tag = ""; // will be filled by openssl_encrypt
        $ciphertext = openssl_encrypt($value, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag, "", self::TAG_LENGTH);
        return $this->encode($iv.$tag.$ciphertext);
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

    private function creatKey()
    {
        $config = array(
            "digest_alg" => "sha256",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        
        // Create the private and public key
        $res = openssl_pkey_new($config);
        
        // Extract the private key into $private_key
        openssl_pkey_export($res, $private_key);
        
        // Extract the public key into $public_key
        $public_key = openssl_pkey_get_details($res);
        $this->publicKey = $public_key["key"];

    }

    /**
     * decript a string 
     *
     * @param [string] $textToDecrypt
     * @param [string] $password
     * @return string
     */
    public function decript(string $textToDecrypt):string
    {
        $encrypted = $this->decode($textToDecrypt);
        $key = $this->publicKey;
        $iv_len = openssl_cipher_iv_length(self::CIPHER);
        $iv = substr($encrypted, 0, $iv_len);
        $tag = substr($encrypted, $iv_len, self::TAG_LENGTH);
        $ciphertext = substr($encrypted, $iv_len + self::TAG_LENGTH) ;
        return  json_decode(openssl_decrypt($ciphertext, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv, $tag));
        
    }
}
