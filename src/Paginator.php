<?php
namespace app\src;
class Paginator
{
    protected $per_page;
    protected $range;
    protected $current;
    protected $reqString = '';//строка запроса ?par1=val1&page=
    protected $arLinks = []; //массив ссылок на страницы вида ["<<"=>"?blabla&page=1",'20'=>"?blabla&page=20",'21'=>"?blabla&page=21"]
    protected $max_page = 1;//количество страниц на текущем списке

    /**
     * @param mixed[] $config
     * @param int $row_count кол-во строк в списке
     */

    public function __construct($config, $row_count)
    {
        $this->per_page = $config["per_page"];
        $this->range = $config["range"];
        $this->max_page = ceil($row_count / $this->per_page);
        isset($_GET['page']) ? $this->current = $_GET['page'] : $this->current = 1;
        if ($this->current > $this->max_page) $this->current = $this->max_page;
    }

    /**
     * @return int return current page
     */
    public  function getCurrent(){
        return $this->current;
    }

    /**
     * @return array  отдаем лимиты для запроса  к базе
     */
    public function getLimits(){
        $lim = ($this->current-1)*$this->per_page;
        return [$lim,$this->per_page];
    }

    /**
     * Создаем строку запроса
     */
    protected function makeReqString()
    {
        $links = $_GET;
        if (isset($links['page'])) unset($links['page']);
        if (isset($links['_url'])) unset($links['_url']);
        $this->reqString = "?" . http_build_query($links) . "&page=";
    }

    /**
     * Создаем массив ссылок
     */
    protected function createArLinks()
    {
        $range = $this->range;
        $max_page = $this->max_page;
        $current = $this->current;
        $wrap = true;//обернуть пагинатор в кнопки "предыдущая" "сдедующая" "в начало" "в конец" либо нет
        //---------------------------
        if ($max_page <= $range * 2 + 1) {//если кол-во страниц меньше диапазона отображения то показываем все
            $range_down = 1;
            $range_up = $max_page;
            $wrap = false;// отменили добавочные кнопки
        } else {  //
            $range_up = $current + $range;
            if ($range_up > $max_page) $range_up = $max_page;//ограничиваем верхний порог
            $range_down = $current - $range;
            if ($range_down < 1) $range_down = 1;//нижний порог
        }
        //---------------------------добавим кнопки "в начало" и "предыдущая" ------------------------------
        if ($wrap) $this->addPrevButtons();
        //------------------заполняем массив ссылок от нижнего до верхнего диапазона---------------------------------------
        for ($i = $range_down; $i <= $range_up; $i++) {
            $this->arLinks["$i"] = $this->reqString . $i;
        }
        //---------------------------добавим кнопки "в конец" и "следующая" ------------------------------
        if ($wrap) $this->addNextButtons();
    }

    protected function addPrevButtons()
    {
        $current = $this->current;
        $range = $this->range;
        //----------------------------добавим кнопки в начало-------------------------
        if ($current - $range > 1) {
            $this->arLinks['<<'] = $this->reqString . "1";
        }
        //=================================================================
        if ($current > 1) {
            $prev = $current - 1;
            $this->arLinks['<'] = $this->reqString . $prev;
        }
    }

    protected function addNextButtons()
    {
        $max_page = $this->max_page;
        $current = $this->current;
        $range = $this->range;
        //----------------------------добавим кнопки в конец--------------------------------

        if ($current < $max_page) {
            $next = $current + 1;
            $this->arLinks['>'] = $this->reqString . $next;
        }
        //=========================================
        if ($current + $range < $max_page) {
            $this->arLinks ['>>'] = $this->reqString . $max_page;
        }
    }


    public  function render()
    {
        if($this->max_page==1)return null;//если страница одна то не отрисовываем
        $this->makeReqString();
        $this->createArLinks();
        //---------формирование html ------------------------------
        $out = "<ul class='paginator'>";
        foreach ($this->arLinks as $k => $v) {
            $out .= $this->render_el($k, $v);
        }
        $out .= "</ul>";
        return $out;
    }

    protected  function render_el($num, $ref)
    {
        $active = ($num == $this->current) ? "active" : ""; //добавляем класс active если кнопка текущая
        return "<li class='paginator-cell  {$active}'><a href='{$ref}'>{$num}</a></li>";
    }
}