<?php
use Core\App;
use Core\File;
use Core\View\View;

$app = App::getInstance(new File(__DIR__));

view("error");
require_once 'routes/route.php' ;

// $app->view->render("error",["name"=>"alaa"]);
echo view("error");

// die();

$app->router->scan();


// die();
