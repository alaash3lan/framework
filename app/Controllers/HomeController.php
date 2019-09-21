<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Core\Http\Request;
use Core\Session;
use Core\Cookie;

class HomeController extends Controller
 {
    
    public  function index(Request $request)
    {   
        $c = new Cookie();
        // $c->set("name","alamo",1200);
        // print_r($_COOKIE);
        $c->destroy("name");
        print_r($_COOKIE);

        // $session = new Session();
        
        // //  pred($session->get("userData","username"));
        //  view("index","name");
    }
    public  function test(Request $request)
    {      
        $s = new Session();
        $request->flashOnly(["username","psw"]);
       var_dump($s->all());
        
    }
}


