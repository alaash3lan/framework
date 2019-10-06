<?php
use Core\Request;
use Core\App;

function redirect($url)
{
    $root = dirname($_SERVER["SCRIPT_NAME"]);
    header("Location: {$root}/{$url}");
    die();
}


 function app(File $file = null)
{     
    return App::getInstance();
}
/**
 * view static page
 *
 * @param string $path
 * @param array $data
 * @return void
 */
function view(string $path ,array $data = []) {  
    
    app()->view->render($path,$data);   
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







