<?php
/**
 * Простая функция по автозагрузки а-ля PSR-4
 * @param string $name
 * @throws Exception
 * @return void
 */
function autoload1($name){
    $path_segments = explode("\\",$name);
    array_shift( $path_segments );
    $path = ROOTDIR.DS.implode(DS,$path_segments).".php";
    if(file_exists($path)){
        require_once $path;
    }else{
        //throw new Exception("Класс $name по пути $path не обнаружен");
    }
}
spl_autoload_register('autoload1');

