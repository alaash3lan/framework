<?php
namespace Core\storage;
use HZ\Contracts\Storage\SessionInterface;

class Session implements SessionInterface
{
    /**
     * calling start  function
     * return void
     */
    public function __construct() 
    {
        $this->start();
    }

    /**
     * start the session 
     * @return void
    */
    public function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    }
    
    /**
     * destroy the session 
     *
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }


    /**
     * store values in session function
     *
     * @param string $key
     * @param [mixed] $value
     * @return void
     */
    public function store(string $key,$value)
    {
        $_SESSION[$key] = $value; 
    }
    


    /**
     * Set new value to the container
     * 
     * @param   string $key
     * @param   mixed $value
     * @return  void
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    /**
     * Check if the container has a value for the given key  
     * 
     * @param   string $key
     * @return  boolean
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);   
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
       return $_SESSION[$key] ?? $default;       
    }
    
    /**
     * Get all stored values in the container
     * 
     * @return  iterable
     */
    public function all(): iterable
    {
        return $_SESSION;
    }
    
    /**
     * Remove the value from the container
     * 
     * @param   string $key
     * @return  void
     */
    public function remove(string $key)
    {
        unset($_SESSION[$key]);      
    }

   
}