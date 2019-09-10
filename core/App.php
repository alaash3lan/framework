<?php
class App 
{   
    public $route;
    public $requset;

    /**
     * construct instantiate route and request
     */
    public function __construct() {
        $this->route     = new Route();
        $this->request   =   new Request();
    }
}