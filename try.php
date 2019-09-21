<?php
//     1- add function 'flash' and 'flashOnly' to "Request" class to save inputs itnto session
//     2- work on cook
// 

$arr = [
    'name' => 'alaa',
    'index2' => 'html',
    'index3' => 'slide',
    'age' => '55',
    
];
$options = ["name","age"];
$session= [];
foreach ($options as  $key) {
   $session[] = $arr[$key];
}
var_dump($session);