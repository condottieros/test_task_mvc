<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

use app\src\Router;
use app\src\Registry;
use app\src\Dispatcher;
use app\src\Paginator;
use app\src\Connection;

require_once './config/constants.php';
require_once './config/autoload.php';
//-------------------------------------------
$config = include "./config/config.php";
Registry::set('config',$config);
//-------------------------------------------
try{
    $connect = new Connection($config['db']);
    Registry::set('connect',$connect);
    //-----------------------------------------------------
    $request = new \app\src\Request($config['routes']);
    Registry::set('request',$request);
    //-----------------------------------------------------
    $dispatcher = new app\src\Dispatcher();
    $pattern = $request->route();
    $out = $dispatcher->dispatch( $pattern );
    echo $out;
}catch(Exception $e){
    echo $e->getMessage();
}


