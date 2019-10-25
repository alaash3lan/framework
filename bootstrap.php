<?php
use Core\App;
use Core\File;
use Core\View\View;

$file = new File(__DIR__);
$app = App::getInstance($file);

require_once 'routes/route.php' ;

$app->router->scan();

