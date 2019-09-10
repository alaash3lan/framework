<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Core\Http\Request;

class HomeController extends Controller
 {
    
    public  function index(Request $request)
    {     
         view("index","alaa");
    }
    public  function test(Request $request)
    {   
        $v = $request->validate([
            "email" => "required|max:255|email",
        ]);
        print_r($v);
    }
}


