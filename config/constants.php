<?php
//-------------------------------constants-----------------------------
const DS  = DIRECTORY_SEPARATOR;
define ("ROOT",$_SERVER['HTTP_HOST']);
define ("ROOTDIR" , dirname( __DIR__));

//---------------------functions------------------------
/**
 * @param string $date
 * @return string
 */
function form_date($date){
    $date = strtotime($date);
   $date = date("d F Y ",$date)."<sup>".date(" G:i",$date)."</sup>" ;
   if($date[0]=== '0') return substr($date,1);
   return $date;
}
function view_block($path,$par=[]){
    extract($par);
    include ROOTDIR.DS."views".DS.str_replace('/',DS,$path).".php";
}
///------------------------------------------------------
const PRE = "<pre>";
function jj($n){
    echo PRE;
    var_dump($n);
    exit;
}
function sj($n){
    echo PRE;
    print_r($n);
    exit;
}