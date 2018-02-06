<?php
namespace app\src;
class Dispatcher
{
    /**
     * @param string $pattern
     * @return mixed
     */
    public function dispatch($pattern){
        //строки вида post:delete переводим в названия классов контроллера и экшенов
        $pattern = explode(":",$pattern);
        $controller = "app\\controllers\\".ucfirst($pattern[0])."Controller";
        $action = "action".ucfirst($pattern[1]);
        //создаем инстанс контроллера и выполняем экшн
        $c = new $controller;
        return $c->$action();
    }
}