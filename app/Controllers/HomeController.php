<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Core\Http\Request;
use Core\Session;

class HomeController extends Controller
 {
    
    public  function index(Request $request)
    {   
        $session = new Session();
        
        //  pred($session->get("userData","username"));
        //  view("index","name");
    }
    public  function test(Request $request)
    {      
        // // print $_SESSION["userId"];
        $session = new Session();
       print $session->get("alaa","name");
        // $session->destroy();
        // $session->store("name", "alaa");
        // print $_SESSION["name"];
       

        // var_dump($session->all());
        // if ($session->has("username"))
        // {
        //     print "okaaay";
        // }
        
        // $session->remove("username");
        // print  $session->get("username");
        
        
        
        // $data = ["name" => "alaa","id"=>7];
        // $session->store("sessionOne",$data);
        // print_r($session->get("sessionOne"));
       
    }
}


