<?php

use Core\Route;



$route->add("get","home","HomeController@index");
$route->add("post","home","HomeController@test");
$route->add("get", "test","TestController@test");
