<?php
namespace Core\Http;

class Session 
{

    public function __construct() {
        $this->start();
    }
    /**
     * start the session 
     * @return void
     */
    public  function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    }
    
    /**
     * destroy the session 
     *
     * @return void
     */
    public function end()
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
     * get value stored in session by given name of session and key of the value
     *
     * @param string $sessionName
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
       return $_SESSION[$key];
    }

   
}