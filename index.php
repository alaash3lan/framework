<?php
require_once __DIR__ . "/vendor/autoload.php" ;
require_once __DIR__ . "/core/helpers.php";
require_once __DIR__ . "/bootstrap.php";

require_once 'routes/route.php' ;
$app->router->load();
