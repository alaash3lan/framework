<?php


// $app->router->add("get","/home","HomeController@index");
$app->router->get("","HomeController@index");
$app->router->get("/home","HomeController@index");
$app->router->get("/test","HomeController@test");




