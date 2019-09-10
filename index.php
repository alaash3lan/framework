<?php
require_once('vendor/autoload.php');

require_once('core/helpers.php');
use Core\Route;
$route = new Route();
require_once('routes/route.php');
$route->load();
