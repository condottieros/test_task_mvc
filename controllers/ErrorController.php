<?php
namespace app\controllers;
class ErrorController{
    public function actionNotFound(){
        return "<h3 style='text-align:center;margin:100px'>Запрашиваемая страница не существует</h3>";
    }
}