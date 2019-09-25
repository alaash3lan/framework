<?php
namespace Core;
use Core\Http\Router;
use Core\Http\Request;
class App 
{   
    public $router;
    public $requset;

    /**
     * construct instantiate route and request
     * return void
     */
    public function __construct() 
    {
        $this->request   =   new Request();
        $this->router     = new Router($this->request);
    }
}