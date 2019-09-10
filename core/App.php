<?php
namespace Core;
use Core\Route;
use Core\Http\Request;
class App 
{   
    public $router;
    public $requset;

    /**
     * construct instantiate route and request
     */
    public function __construct() 
    {
        $this->router     = new Route();
        $this->request   =   new Request();
    }
}