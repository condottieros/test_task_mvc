<?php
namespace app\models;
use app\src\Model;
use app\src\Registry;
use PDO;

class Post extends Model
{
    /**
     * @property string $name  заголовок
     * @property string $message  тело поста
     * @property string $id идентификатор
     * @var string
     */
    protected static $table = 'post';
    protected static $monthNames = [1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель', 5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август', 9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'];

    public static function getArchieve(){
        $q = 'SELECT DATE_FORMAT(date, "%Y") AS year, DATE_FORMAT(date, "%c") AS month from post group by year, month ORDER BY year desc, month desc';
        $arch = static::$conn->run($q)->fetchAll(PDO::FETCH_ASSOC);
        foreach($arch as $k => $item)
        {
            $arch[$k]['month_name'] = static::$monthNames[$item['month']];
        }
        return $arch;
    }
    public static function getMonthName($index){
        if(isset(self::$monthNames[$index]))return self::$monthNames[$index];
        return null;
    }

    /**
     * @param array $del
     * @return bool
     */
    public static function multipleDel($del = []){

        $tbl = static::$table;
        static::setDb();
        $plh  = rtrim( str_repeat("?,",count($del)), ",");
        $q = "DELETE FROM {$tbl} WHERE `id` IN($plh)";
        return static::$conn->run($q,$del,null);
    }

}