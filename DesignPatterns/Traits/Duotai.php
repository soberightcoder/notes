<?php

/**
 * Class Duotai
 * 多态
 * 相同的方法 调用
 */
abstract class Duotai
{
   abstract function ceshi();
}

class Model1 extends Duotai
{
   public function ceshi() {
       echo "model1";
   }
}

class Model2 extends Duotai
{
    public function ceshi() {
        echo "model2";
    }
}


function ceshi(Duotai $obj){
   $obj->ceshi();
}
$model1 = new Model1;
ceshi($model1);
echo "\n";
$model2 = new Model2();
ceshi($model2);
echo "\n";
echo "\n";
//const PI = 3.14;