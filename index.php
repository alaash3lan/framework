<?php
require_once('vendor/autoload.php');
require_once('core/helpers.php');
use Core\App;

$app = new App();
require_once('routes/route.php');
$app->router->load();
