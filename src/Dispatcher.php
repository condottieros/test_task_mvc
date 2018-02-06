<?php
namespace app\src;
class Dispatcher
{
    /**
     * @param string $pattern
     * @return mixed
     */
    public function dispatch($pattern){
        //������ ���� post:delete ��������� � �������� ������� ����������� � �������
        $pattern = explode(":",$pattern);
        $controller = "app\\controllers\\".ucfirst($pattern[0])."Controller";
        $action = "action".ucfirst($pattern[1]);
        //������� ������� ����������� � ��������� ����
        $c = new $controller;
        return $c->$action();
    }
}