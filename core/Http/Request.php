<?php
namespace Core\Http;
use HZ\Contracts\Http\RequestInterface ;
use Core\Storage\Session;
use Core\Http\Validator;

class Request implements RequestInterface
{
    // the current root of app  $root/..
    public $root;
    

    /**
     * current route 
     * @var string
     */
    public $route;

    /**
     * the query strings of url
     *
     * @var array
     */
    private $queries = [];

    /**
     * Request constructor.
     * @return  void
     */
    public function __construct()
    {
        $this->root =  dirname($_SERVER["SCRIPT_NAME"]);
        $this->prepareUrl();
    }

    /**
     * Get value from the query parameters ie from _GET global variable
     * If not exists, return null
     * 
     * @param   string $key
     * @return  mixed
     */
    public function get(string $key)
    {
        return $this->getValueFromVariable($_GET,$key);   
    }

     /**
     * get the current url
     * return string
     */
    public function url():string
    {
        return $_SERVER["REQUEST_URI"] ;   
    }


    /**
     * Get value from the request body ie from _POST global variable
     * If not exists, return null
     * 
     * @param   string $key
     * @return  mixed
     */
    public function post(string $key)
    {
        return $this->getValueFromVariable($_POST,$key);       
    }

    /**
     * Get value from the _SERVER global variable
     * If not exists, return null
     *
     * @param string $key
     * @return  mixed
     */
    public function server(string $key)
    {
        return $this->getValueFromVariable($_SERVER,$key);
    }


    /**
     * Get value from the _FILES global variable
     * If not exists, return null
     * 
     * @param   string $key
     * @return  mixed
     */
    public function file(string $key)
    {
        return $this->getValueFromVariable($_FILES,$key);
    }

    /**
     * prepare the url
     */
    public function prepareUrl()
    { 
        $requestUri = $_SERVER['REQUEST_URI'];

        if (!empty($_SERVER['QUERY_STRING'])) {
            list($requestUri) = explode('?' , $requestUri);
            $this->saveQueryString();
        } 
        
        $this->route =   rtrim(preg_replace('#^'.$this->root.'#', '' , $requestUri), '/');     
    }


    /**
     * get the current route
     *
     * @return string
     */
    public function route() :string
    {
       return $this->route;
    }

    /**
     * save generate var of query string
     *
     * @param [type] $queryString
     * @return void
     */
    public function saveQueryString()
    {
        $queries = [];
        parse_str($_SERVER['QUERY_STRING'], $queries);
        $this->queries = $queries;
    }

    
    /**
     * return query string valu of given key, 
     * the default if no $key given will return all queris in an array
     *
     * @param string $key
     * @return void
     */
    public function query(string $key = "allQueris")
    {
        if ($key == "allQueris" ) return $this->queries;
        return $this->queries[$key];    
    }


    /**
     * Validate the given inputs by the given rules
     * Rules are listed in array
     * Returns array contains the input name and the value is the error message
     * If all rules are valid, return true
     *   
     * @param   array $rules
     * @return  array|true
     */
    public function validate(array $rules):? array
    {   
        $errors = [];
        $validator = new Validator();

        foreach ($rules as $key => $value) {
            $values = explode("|",$value);
        // whoops    
            foreach ($values as $rule) {
                if(strpos($rule,":")){
                    $array = explode(":",$rule);
                    $ruleMethod = $array[0];
                    if($error = $validator->$ruleMethod($key,$this->post($key),$array[1])){
                          $errors[]= $error;
                    }
                } elseif($error = $validator->$rule($key,$this->post($key))){
                    $errors[]= $error;
                }
            }           
        }

        if(!empty($errors)) {
            return $errors;
        } else {
            return null;
        }
    }


    /**
     * Get the value from global variable 
     * If not exist return Null
     *
     * @param mixed $variable
     * @param string $key
     * @return mixed
     */
    private function getValueFromVariable($variable,string $key)
    {
        return $variable[$key] ?? $null;
    }


    /**
     *  return all request data
     * 
     */
    public function data()
    {
      return $_REQUEST;
    }

     /**
     * Check if the container has a value for the given key  
     * 
     * @param   string $key
     * @return  boolean
     */
    public function has(string $key): bool
    {
        return isset($_REQUEST[$key]);   
    }


    

    /**
     * Flash the current input to the Session
     *
     * @param Type $var
     * @return void
     */
    public function flash()
    {   
        $data = $this->data();
        foreach ($data as $key => $value) {
           $this->session->store($key,$value);
        }     
    }


    /**
     * flash only those keys in session 
     *
     * @param array $inputs
     * @return void
     */
    public function flashOnly(array $inputs)
    {
        foreach ($inputs as $key) {
            if ($this->has($key)) $this->session->store($key,$this->data()[$key]);
        }        
    }


      /**
     * Determine if current request is served by https request
     * 
     * @return bool
     */
    public function isSecure(): bool
    {
      return !empty($_SERVER['HTTPS']);
    }


       /**
     * Get current ip
     * 
     * @return string
     */
    public function ip() :string
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


     /**
     * Get user agent
     * 
     * @return string
     */
    public function userAgent():string
    {
       return $_SERVER['HTTP_USER_AGENT'];
    }
    
}