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
         view("index","name");
    }

        
    public  function test(Request $request)
    {      
        $s = new Session();
        $request->flashOnly(["username","psw"]);
       var_dump($s->all());        
    }
}


