<?php
namespace Core;
use Core\Connection;
class DB 
{

    public  $pdo;
    public $tableName;
    public $key;
    public $keyValue;
    public function __construct() 
    {
       $this->startConnection();
    }


   /**
    * call openConnection function from Connection class 
    *
    * @return void
    */
   private function startConnection()
   {
      $connection = Connection::getInstance();
      $this->pdo = $connection->openConnection();
      
   }

   /**
    * Add the name of table to object
    *
    * @param string $name
    * @return void
    */
   public function table(string $name)
   {
       $this->tableName = $name;
       return $this;
   }
   

   /**
    * add a key and it's value for record function
    *
    * @param string $key
    * @param [mixed] $value
    * @return DB
    */
   public function where(string $key, $value)
   {
       $this->key = $key;
       $this->keyValue = $value;
       return $this;
       
   }

     /**
    * get all from the table
    *
    * @return void
    */
    public function get()
    {
         $sql =  'SELECT * FROM ' .$this->tableName;
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute();
         return $stmt->fetchAll();
        
    }


     /**
    * get first table by give name od the table and id 
    *
    * @return array
    */
   public function first()
   {
        $sql =  'SELECT  * FROM '.$this->tableName ;
        $sql .=' WHERE ';
        $sql .= $this->key;
        $sql .=  '= ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->keyValue]);
        return $stmt->fetch();
       
   }
   

      /**
    * delete table by given name and the id 
    *
    * @return void
    */
    public function delete()
    {
         $sql =  'DELETE FROM '.$this->tableName ;
         $sql .=' WHERE ';
         $sql .= $this->key;
         $sql .=  '= ?';
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([$this->keyValue]);
        
    }


      /**
    * update table by given name of the table and the id 
    *
    * @param [string] $table
    * @param [mixed] $id
    * @param [array] $data
    * @return void
    */
   public function update(array $data)
   {
        
        $sql =  "UPDATE $this->tableName";
        $sql .= " SET ";

        foreach ($data as $key => $value) {
         $sql .= "$key = ? , ";
        }

        $sql .=" WHERE {$this->key}  = ? " ;
        //clear last ( , ) from sql 
        $sql[-17]= " ";
    
        $boundValues =array_values($data);
        $boundValues[] = $this->keyValue;  

        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($boundValues);
        
        return $this->first($this->tableName,$this->keyValue);   
   }
    

}

