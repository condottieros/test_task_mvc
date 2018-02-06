<?php
namespace app\src;
class Model
{
    /**
     * @var  Connection
     */
    protected static $conn;
    /**
     * @var string Имя таблицы
     */
    protected static $table = "";
    /**
     * @var mixed[]  Массив с полями
     */
    protected $data = [];
    public function __construct(){
        static::setDb();
    }

    /**
     * @param string $prop
     * @return bool|mixed
     */
    public function __get($prop){
        if(!isset($this->data[$prop])) return false;
        return $this->data[$prop];
    }

    /**
     * @param string $name
     * @param mixed $val
     */
    public function __set($name,$val){
        $this->data[$name] = $val;
    }
    public function save(){
        $table = static::$table;
        if(isset($this->data['id'])){
            $params = join(",", array_map( function($val){return $val.="=?";}, array_keys($this->data))); //name=?,message=?
            $values = array_values($this->data);
            $qw = "UPDATE {$table} SET {$params} WHERE id={$this->data['id']}";
            return static::$conn->run($qw,$values,null);
        }else{
            $columns = array_keys($this->data);
            $columns = implode(',',$columns);// ==> name,value
            $plholdrs = rtrim( str_repeat("?,", count($this->data) ), ",");//==>  ?,?,?,?,?
            $values = array_values($this->data);
            $qw = "INSERT INTO {$table}({$columns})VALUES({$plholdrs})";
            return static::$conn->run($qw,$values,'insert');
        }
    }
    public function delete(){
        $table = static::$table;
        if(isset($this->data['id'])){
            $qs = "DELETE FROM `$table` WHERE `id`=?";
            return static::$conn->run($qs,[$this->data['id']],null);
        }
        return null;
    }
    public static function find(){
        static::setDb();
        static::$conn->init(static::$table,static::class);
        return static::$conn;
    }
    protected static function setDb(){
        static::$conn = Registry::get('connect');
    }
}