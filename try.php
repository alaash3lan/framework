<?php

interface Machine 
{
    public function move();
}
interface Bus 
{
    public function cost();
}

class SmallBus implements Bus
{
    public function cost()
    {
       return "smal";
    }
}

class Car implements Machine ,Bus
{
   public function move()
   {
      print "sdsd";
   }
   public function cost()
   {
       return "30g";
   }
}
 function printOOB(Bus $b)
{
   print $b->cost();
}
// $car = new Car();
// $car->cost();
// $car->move("sdsd");
$s = new Car();
printOOB($s);