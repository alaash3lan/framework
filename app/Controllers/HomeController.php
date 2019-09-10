<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Core\Http\Request;

class HomeController extends Controller
 {
    
    public  function index(Request $request)
    {   
        // print $request->route();
        // print_r(json_encode($_SERVER));
        // print_r($request->get("pigo"));       
         view("index","alaa");
    }
    public  function test(Request $request)
    {   
        // pred($request->post("email"));
        $v = $request->validate([
            "email" => "required|max:255|email",
        ]);
        print_r($v);

        // redirect("/home");
    }
}


