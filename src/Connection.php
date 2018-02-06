<?php
namespace app\src;
use PDO;

/**
 * Class Connection
 * @package app\src
 * Соединение с бд и кверибилдер в одном (налицо нарушение single responsibility principe)
 */
class Connection
{
    /**
     * @var PDO
     */
    protected $conn;
    /**
     * @var string Данные запроса для квери билдера
     */
    protected $query = " * ";
    protected $limit=null;
    protected $where=null;
    protected $order=null;
    protected $where_p;//значения для подстановки в плейсхолдеры в where
    protected $table;//таблица для текущего запроса
    /**
     * @var string Класс для гидрации
     */
    protected $class;
    public function __construct($config){
        $this->conn = new PDO($config['host'],$config['user'],$config['password']);
    }

    /**
     * @param $query
     * @param array $params
     * @param mixed select //если нужен селект то просто пропустим параметр,если инсерт апдейт или делит то ставим хоть что, тупо null
     * @return \PDOStatement|bool|int
     */
    public function run($query,$params=[],$type='select'){
        $st = $this->conn->prepare($query);
        $bool = $st->execute($params);
        if( $type==='select' )return $st;// for fetch
        if($type==='insert'){
            if($bool)return $this->conn->lastInsertId();
        }
        return $bool;
    }

    public function init($table,$class=null){
        $this->table = $table;
        $this->class = $class;
        $this->query = "*";
        $this->limit = null;
        $this->where = null;
        $this->order = null;
        return $this;
    }
    public function where($param=[]){  //
        $phs = array_keys($param);
        foreach($phs as &$val){
            $val .= "?";
        }
        $this->where = " WHERE ".implode(" AND ",$phs);
        $this->where_p = array_values($param);
        return $this;
    }
    public function in($name,$ar){ // operator IN  ==>make string "[AND] `name` IN(?,?,?,?)" and concat it to WHERE
        //-----create string---------------------------------
        $plh = rtrim( str_repeat("?,", count($ar) ), ",");
        $qp = " $name IN ($plh)";
        //----------concat to where-condition------------------
        $and = trim($this->where)==="WHERE" ? "":" AND ";
        $this->where .= $and.$qp;
        //-----------------add placeholders--------------------
        $this->where_p = array_merge($this->where_p,$ar);
        return $this;
    }
    public function limit($row,$num=null){
        $this->limit = " LIMIT $row";
        if($num)$this->limit .= ",$num ";
        return $this;
    }
    public function count($param="*"){
        $this->query = " COUNT($param) ";
        return $this->exec()->fetch(PDO::FETCH_COLUMN);
    }
    public function order($str = []){
        $str = implode(',',$str);
        $this->order = " ORDER BY {$str} ";
        return $this;
    }

    /**
     * @return \PDOStatement
     */
    protected function exec(){
        $string = "SELECT {$this->query} FROM {$this->table}";
        if($this->where) $string .=$this->where;
        if($this->order) $string .=$this->order;
        if($this->limit) $string .=$this->limit;
        return $this->run($string,$this->where_p);
    }
    public function all(){
        return $this->exec()->fetchAll(PDO::FETCH_CLASS,$this->class);
    }
    public function one(){
        $this->limit(1);
        $stmt = $this->exec();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->class);
        return $stmt->fetch();
    }
}
