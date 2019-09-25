<?php
namespace Core;

use Core\AppReflector;
use Core\Http\Request;
use HZ\Contracts\Http\RouterInterface;
class Route 
{   
    public $routes = [];
    public $root ;
    public $currentUrl;

    /**
     * Construct  of the class
     * 
     * making new request object
    */
    public function __construct()
    {
        $this->request = new Request();
        $this->root = str_replace("/index.php","",$_SERVER["SCRIPT_NAME"]);
        $this->currentUrl =  $this->request->url();
    }
    

    /**
     * get current route
     *
     * @return string
     */
    private function CurrentRoute(): string
    {
        return  str_replace($this->root,"",$this->currentUrl); 
    }
        

    
    /**
     * add route to array of the routes of the app 
     *
     * @param string $method
     * @param string $route
     * @param string $action
     * @return void
     */
    public function add (string $method,string $route,string $action )
    {   
        $this->routes[]= [$method,$route,$action];
    }
    

    /**
     * match the current url with stored routes if not found return not found page
     *
     * @return void
     */
    public function load()
    {   
        foreach ($this->routes as  $route) {
            if($this->isMatching($route)){
                return $this->controllerTriger($route[2]);         
            }           
        }
       return  view("error");
    }

    /**
     * cheack if current request match specific route 
     *
     * @param array $route
     * @return boolean
     */
    public function isMatching(array $route)
    {
      $pattern =  $this->generatePattern($route[1]);
      return $_SERVER['REQUEST_METHOD'] == strtoupper($route[0]) & preg_match($pattern, $this->CurrentRoute());
    }


    /**
     * generate a pattern for route 
     *
     * @param string $url
     * @return string
     */
    public function generatePattern(string $url) :string
    {
      $pattern  = "#^";
      $pattern .= str_replace([':text', ':id'], ['([a-zA-Z0-9z]+)','(\d+)'],$url);
      $pattern .="$#";
      return $pattern;
    }
    

    /**
     * get the arguments from the url  
     *
     * @param [type] $pattern
     * @return array
     */
    public function getArguments($pattern) :array
    {
        preg_match($pattern, $this->request->url(),$matches);
        array_shift($matches);
        return $matches;
    }



    /**
     * Split up action into class and function then call the function
     *
     * @param [type] $action
     * @return void
     */
    public function controllerTriger($action)
    {
        list($class,$classFunction) = explode("@",$action);
        $classNamespace = "App\Controllers\{$class}";
        $classNamespace = str_replace(["{","}"],"",$classNamespace);
        $app = new AppReflector($classNamespace);
        $params =  $app->getMethodParams($classFunction);
        $arg = [];

        foreach ($params as $param) {
            $arg[] = new $param;
        }

        call_user_func_array(array($classNamespace,$classFunction,),$arg);  
    }

}
