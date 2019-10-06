<?php
class alaa {
    public $ar = [];
      public function hasAlaa()
      {
         print 'alaa';
      }

}
class one 
{
    public $alaa;

    public function __construct($alaa) {
        $this->alaa = $alaa;
    }
    public function printName($value)
    {
        if ($value instanceof Closure) {
            $value = call_user_func($value, $this);
        }
        print $value;
    }
}
$a = new alaa();
$a->ar = ["name","age"]; 
$t  = new one($a);
$t->printName( function()
{
    return "lulu";
});
var_dump($t->alaa->ar);


