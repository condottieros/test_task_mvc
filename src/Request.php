<?php
namespace app\src;
/**
 * Class Request
 * @package app\src
 */
class Request
{
    /**
     * @var mixed[]
     * Роуты из конфига
     */
    protected $routes;
    /**
     * @var mixed[]
     * Переменные запроса со значениями
     */
    protected $req_vars = [];

    public function __construct($config = [])
    {
        $this->routes = $config;
    }
    /**
     * Матчинг пути запроса и имен контроллера и экшена
     */
    public function route()
    {
        //определяем строку запроса,если пустая то корневой маршрут
        if( !isset($_GET['_url'])){
            $url = "/";
        }else{
            $url = strtolower(rtrim($_GET['_url'],'/'));
        }

        $matched = false;//было совпадение или нет
            foreach($this->routes as $route=>$pattern){
            //заменим в роутах плейсхолдеры в фигурных скобках на регулярки /post/{id}-->/post/([a-z0-9]+)
            $regex = "#^".preg_replace("#{\\w+}#","([a-z0-9_]+)",$route)."$#";
            //извлеченные из фиг.скобок плейсхолдеры будут именами переменных {id}-->id
            $req_vals = [];//значения переменных запроса
            $matched = preg_match($regex,$url,$req_vals);

            if($matched){
                //вытаскиваем сюда из роутов имена переменных archieve/{month}/{year}-->["{month}","{year}"]--потом триммим скобки
                $req_names  = [];//имена переменных запроса
                preg_match_all("#{\\w+}#",$route,$req_names);
                $req_names = $req_names[0];
                foreach($req_names as &$name){
                    $name = trim($name,"{}");
                }
                //Формируем массив переменных
                foreach($req_names as $k=>$v){
                    $this->req_vars[$v] = $req_vals[$k+1];
                }
                return $pattern;//совпадение найдено выходим из цикла

            }
        }
        //прошлись по циклу - ничего не нашли - 404
        return  $this->routes['404'];
    }
    public function get($name){
        if(isset($this->req_vars[$name])) return $this->req_vars[$name];
        return false;
    }
}