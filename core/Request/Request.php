<?php
namespace Core\Request;
use HZ\Contracts\Http\RequestInterface ;
use Core\Request\RequestValidation;

class Request
{
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
     * @param   string $key
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
     * {@inheritDoc}
     */
    public function route(): string
    {
        $root = substr($_SERVER["SCRIPT_NAME"],0,5);
        return str_replace($root,"",$_SERVER["REQUEST_URI"]);
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

        foreach ($rules as $key => $value) {
            $values = explode("/",$value);
            
            foreach ($values as $rule) {
                if(strpos($rule,":")){
                    $array = explode(":",$rule);
                    $ruleMethod = $array[0];
                    if($error = RequestValidation::$ruleMethod($key,$this->post($key),$array[1])){
                          $errors[]= $error;
                    }
                } elseif($error = RequestValidation::$ruleMethod($key,$this->post($key))){
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
     * @return void
     */
    private function getValueFromVariable($variable,string $key)
    {
        if (isset($variable[$key])){
            return $variable[$key];
        }
        return null;
    }
}