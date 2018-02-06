<?php
namespace app\src;

class User
{
    /**
     * @var Connection
     */
    protected static $conn =  null;

    public static function setDB(){
        static::$conn = Registry::get('connect');
    }
    public function __construct()
    {
        session_start();
        static::setDb();
    }

    public function auth($login, $pass)
    {
        $res = static::$conn->init('user',null)->where(["login="=>$login,"pass="=>$pass])->count();

        if($res > 0)
        {
            $_SESSION['authorized'] = 1;
        } else {
            $_SESSION['authorized'] = 0;
        }
    }

    public function checkAuth()
    {
        if($_SESSION['authorized'] == 1)
        {
            return true;
        }
        else
            return false;
    }
    public function quit(){
        session_destroy();
    }
}