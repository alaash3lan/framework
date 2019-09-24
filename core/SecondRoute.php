<?php
namespace Core;

use Core\AppReflector;
use Core\Http\Request;
use HZ\Contracts\Http\RouterInterface;
class SecondRoute implements RouterInterface
{   
    public $routes = [];
    public $root ;
    public $currentUrl;
    public $currentRoute = [];

     /**
     * Construct  of the class
     * making new request object
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->root = str_replace("/index.php","",$_SERVER["SCRIPT_NAME"]);
        $this->currentUrl =  $this->request->url();
    }
    

     /**
     * Add a GET route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function get(string $route, string $controller): RouterInterface
    {
        $this->add("get",$route,$controller);
        return $this;
    }

    /**
     * Add a POST route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function post(string $route, string $controller): RouterInterface
    {
        $this->add("post",$route,$controller);
        return $this;
    }

    /**
     * Add a PUT route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function put(string $route, string $controller): RouterInterface
    {
        $this->add("put",$route,$controller);
        return $this;
    }

    /**
     * Add a delete route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function delete(string $route, string $controller): RouterInterface
    {
        $this->add("delete",$route,$controller);
        return $this;
    }

    /**
     * Add a PATCH route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function patch(string $route, string $controller): RouterInterface
    {
        $this->add("patch",$route,$controller);
        return $this;
    }

    /**
     * Add a options route
     * 
     * @param  string $route
     * @param  string $action >> controller@method
     * @return RouterInterface
     */
    public function options(string $route, string $controller): RouterInterface
    {
        $this->add("options",$route,$controller);
        return $this;
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
     * get current route
     *
     * @return string
     */
    private function CurrentRoute(): string
    {
        return  str_replace($this->root,"",$this->currentUrl); 
    }
        

    

    /**
     * match the current url with stored routes if not found return not found page
     *
     */
    public function scan()
    {   
        foreach ($this->routes as  $route) {
            if($this->isMatching($route)){
                $this->currentRoute = $route;
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
      $pattern =  $this->generateRoutePattern($route[1]);
      return $_SERVER['REQUEST_METHOD'] == strtoupper($route[0]) & preg_match($pattern, $this->CurrentRoute());
    }


    /**
     * generate a pattern for route 
     *
     * @param string $route
     * @return string
     */
    public function generateRoutePattern(string $route) :string
    {
      $pattern  = "#^";
      $pattern .= str_replace([':text', ':id'], ['([a-zA-Z0-9z]+)','(\d+)'],$route);
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

      /**
     * Get current route with its full options
     * 
     * @return array
     */
    public function current(): array
    {
        return $this->currentRoute;
    }
}
