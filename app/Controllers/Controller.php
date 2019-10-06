<?php
namespace App\Controllers;
use Core\App;

class Controller {
    
    /**
     * app object
     *
     * @var Core\App
     */
    public $app;


    /**
     * construct
     *
     * @param App $app
     */
    public function __construct(App $app) 
    {
        $this->app = $app;
    }


    /**
    * Get shared value of app objects dynamically
    *
    * @param string $key
    * @return mixed
    */
    public function __get($key)
    {
      return $this->app->$key;
    }

    
}
