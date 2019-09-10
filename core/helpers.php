<?php
use Core\Request;

function redirect($url)
{
    $root = str_replace("/index.php","",$_SERVER["SCRIPT_NAME"]);
    header("Location: {$root}/{$url}");
    die();
}

function view(string $path , $data = null) {
        
    require "./static/views/".$path.".php";
}

 function pred($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}









