<?php
namespace Core;
use PDO;
Class Connection {
    private   $server = "mysql:host=127.0.0.1;dbname=user_module";
    private   $user = "root";
    private   $pass = "";
    private   $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
    protected $connection;
    private static $instance;

     /**
     * Disable instantiation.
     */
    private function __construct()
    {
        // Private to disabled instantiation.
    }
    

    /**
     * check if there is no instance of Connection class 
     * then make new instance if no one exist
     * used for singleton pattern
     *
     * @return void
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) static::$instance = new Connection;
        return static::$instance;
    }

 

    /**
     * instantiate new PDO 
     *
     * @return void
     */
    public function openConnection() 
    {
        try {
                $this->connection = new PDO($this->server, $this->user,$this->pass,$this->options);
                return $this->connection;
        } catch (\PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }



    public function closeConnection() {
         $this->connection = null;
      }
}
