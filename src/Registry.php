<?php
namespace app\src;
class Registry
{
    /**
     * @var array $store ������� ������(� �� ������� � ������-������� ;-) )
     */
    protected static $store = [];
    public static function set($name,$value){
        static::$store[$name] = $value;
    }
    public static function get($name){
        if(isset(static::$store[$name])){
            return static::$store[$name];
        }else{
            return false;
        }
    }
}