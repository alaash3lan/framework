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
        // $root = str_replace("/index.php","",$_SERVER["SCRIPT_NAME"]);
        // str_replace($root,"",$_SERVER["REQUEST_URI"]);
        
        $string = $_SERVER["SCRIPT_NAME"].$_SERVER["REQUEST_URI"];
        print $string;
    }
}


