<?php
namespace Core;
use Core\Connection;
class Database 
{

    public  $pdo;
    public function __construct() 
    {
       $this->start();
    }

   private function start()
   {
      $connection = new Connection();
      $this->pdo = $connection->openConnection();
      
   }

   public function get($table)
   {
        $sql =  'SELECT * FROM ' .$table;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
       
   }
   
   

}