<?php
namespace app\src;
class Controller
{
    protected $request;
    public function __construct(){
        $this->request = Registry::get('request');
    }
    /**
     * @param string $path
     * @param mixed[] $params
     * @return string
     * И так все понятно)
     */
    public  function view($path,$params=[]){
        extract($params);
        ob_start();
        include ROOTDIR.DS."views".DS.implode(DS,explode("/",$path)).".php";
        return ob_get_clean();
    }
}