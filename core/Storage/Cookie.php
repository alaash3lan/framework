<?php
namespace Core\storage;
use HZ\Contracts\Storage\CookieJarInterface;
class Cookie implements CookieJarInterface
{
    /**
     * set cookie function
     *
     * @param string  name
     * @param string  value
     * @param integer minutes 
     * @return $this
     */
    public function set(string $name, string $value, int $minutes) :CookieJarInterface
    {
        $time = time() + ($minutes * 60);
        setcookie($name, $value, $time);
        return $this;
    }


    /**
     * Check if the cookie has a value for the given key  
     * 
     * @param   string $key
     * @return  boolean
     */
    public function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * destroy this cookie 
     *
     * @param string $key
     * @return void
     */
    public function remove(string $key)
    {
        unset($_COOKIE[$key]);
        setcookie($key,"", 1);
    }

    /**
     * Get a value from the storage container
     * If no value exists for the given key, return the default value instead
     * 
     * @param   string $key
     * @param   mixed $default
     * @return  mixed
     */
    public function get(string $key, $default = null)
    {
        return $_COOKIE[$key] ?? $default;
    }


      /**
     * Get all cookies
     * 
     * @return iterable
     */
    public function all(): iterable
    {
        return $_COOKIE;
    }


    /**
     * Clear all cookies
     * 
     * @return void
     */
    public function flush()
    {
        foreach ($_COOKIE as $key => $value) {
            $this->remove($key);
        }

    }
}