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
     print $this->view->render("welcome",["name"=>"alaa"]);     
    }

        
    public  function test(Request $request)
    {      


    }
}


