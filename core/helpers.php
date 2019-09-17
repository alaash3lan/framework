<?php
use Core\Request;

function redirect($url)
{
    $root = str_replace("/index.php","",$_SERVER["SCRIPT_NAME"]);
    header("Location: {$root}/{$url}");
    die();
}

/**
 * view static page
 *
 * @param string $path
 * @param [mixed] $data
 * @return void
 */
function view(string $path , $data = null) {       
    require "./static/views/".$path.".php";
}

/**
 * print variable then stop the app
 *
 * @param [mixed] $data
 * @return void
 */
function pred(...$data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    die;
}







