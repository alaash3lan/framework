<?php
namespace Core;
use Core\Http\Router;
use Core\Http\Request;
use core\File;
class App 
{   

    /**
     * instance of app 
     *
     * @var [type]
     */
    private static $instance;


    /**
     * container of objects
     */
    private $container = [];


    /**
     * construct instantiate route and request
     * return void
     */
    public function __construct(File $file) 
    {
        $this->saveToContainer('file',$file);
        // $this->loadHelpers();
    }


    /**
     * check if there is no instance of Connection class 
     * then make new instance if no one exist
     * used for singleton pattern
     *
     * @return void
     */
    public static function getInstance(File $file = null)
    {
        if (is_null(static::$instance)) static::$instance = new App($file);
        return static::$instance;
    }



    /**
     * load helpers 
     *
     * @return void
     */
    private function loadHelpers()
    {
        $this->file->call('core/helpers.php');
    }

    /**
     * svae object to container
     *
     * @param string $key
     * @param [mixed] $value
     * @return void
     */
    public function saveToContainer($key,$value)
    {
        $this->container[$key] = $value;
    }

    
    /**
    * Get shared value dynamically
    *
    * @param string $key
    * @return mixed
    */
    public function __get($key)
    {
       return $this->get($key);
    }


    /**
     * Get Shared Value
     *
     * @param string $key
     * @return mixed
    */
    public function get($key)
    {
        if (! $this->isSharing($key)) {
           
            if ($this->isCoreAlias($key)) {
                $this->saveToContainer($key, $this->createNewCoreObject($key));
            } else {
                die('<b>' . $key . '</b> not found in application container');
            }
        }
        return $this->container[$key];
    }
    
    

    /**
     * Determine if the given key is shared through Application
     *
     * @param string $key
     * @return bool
     */
    public function isSharing($key)
    {
        return isset($this->container[$key]);
    }


     /**
     * Create new object for the core class based on the given alias
     *
     * @param string $alias
     * @return object
     */
    private function createNewCoreObject($alias)
    {
        $coreClasses = $this->coreClasses();
        $object      = $coreClasses[$alias];
        return new $object($this);
    }
    

    /**
     * Determine if the given key is an alias to core class
     *
     * @param string $alias
     * @return bool
     */
    private function isCoreAlias($alias)
    {
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$alias]);
    }


    /**
    * Get All Core Classes with its aliases
    *
    * @return array
    */
   private function coreClasses()
   {
       return [
            'request'        => 'Core\\Http\\Request',
            'router'         => 'Core\\Http\\Router',
            'validator'      => 'Core\\Http\\Validator',

            'cookie'         => 'Core\\Storage\\Cookie',
            'session'        => 'Core\\Storage\\Session',

            'view'          => 'Core\\View\\ViewFactory',

            'db'            =>'Core\\DB',
           
       ];
   }
}