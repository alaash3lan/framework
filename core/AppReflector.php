<?php
namespace Core;
use ReflectionClass;
use ReflectionMethod;

class AppReflector
{
    public $reflectionClass;
    

    /**
     * instantiate new ReflectionClass
     *
     * @param [string] $class
     */
    public function __construct($strign)
    {
       $this->reflectionClass =  new ReflectionClass($class);
    }
    

    /**
     * get params for specific reflection method
     *
     * @param ReflectionMethod $method
     * @param [type] $params
     * @return mixed
     */
    public  function getParameters(ReflectionMethod $method,$params)
    {      
        foreach($method->getParameters() as $param) {   
            array_push($params,(string) $param->getType());       
        }
        return $params;
    }
    
    public function getMethodParams(string $methodName)
    {   
        $params = [];
        foreach($this->reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->name == $methodName) {
                return  $this->getParameters($method,$params);
            }
        
        }
    }



}