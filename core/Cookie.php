<?php
namespace Core;

class Cookie 
{
    /**
     * set cookie function
     *
     * @param string $name
     * @param string $value
     * @param integer $expire in seconds
     * @param string $path default "/"
     * @return void
     */
    public function set(string $name,string $value,int $expire,string $path ="/")
    {
        $time = time()+ $expire;
        setcookie($name, $value, $time, $path);
    }


    /**
     * destroy this cookie 
     *
     * @param string $key
     * @return void
     */
    public function destroy(string $key)
    {
        setcookie($key,"", time()-3600);
    }
}