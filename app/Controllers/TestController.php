<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Core\View;
use Core\DB;
class TestController extends Controller 
{
    
    public  function test()
    {    
      $db = new DB() ;
      $user =  $db->table("users")
      ->where("id",2)
      ->update(["name"=>"amolaa",
               "email"=>"dd"                                         
                              ]);
      print_r($user);
       
    }
    
}


?>
