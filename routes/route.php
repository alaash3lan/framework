<?php


$app->router->add("get","/home/alaa","HomeController@index");
$app->router->add("post","/home","HomeController@test");
$app->router->add("get", "/test","TestController@test");
