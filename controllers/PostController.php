<?php
namespace app\controllers;
use app\models\Post;
use app\src\Controller;
use app\src\Paginator;
use app\src\Registry;

class PostController extends Controller{
    public  function actionIndex()
    {
        $config = Registry::get('config');
        $max_page = Post::find()->count();
        $paginator = new Paginator($config['paginator'],$max_page);
        $lim = $paginator->getLimits();
        $posts = Post::find()->order(['`date` DESC'])->limit($lim[0],$lim[1])->all();
        $archive = Post::getArchieve();
        return $this->view("post/index",["pgn"=>$paginator->render(),"posts"=>$posts,"postArchive"=>$archive]);
    }

    public function actionDetail(){
        $post_id = $this->request->get('id');
        $post = Post::find()->where(['id='=>$post_id])->one();
        $arch = Post::getArchieve();
        return $this->view('post/detail',['post'=>$post,'postArchive'=>$arch]);
    }

    public function actionArchive(){
        $cnf = Registry::get('config');
        $month = $this->request->get('month');
        $year = $this->request->get('year');
        //----------------------------------------
        $max =  Post::find()->where(['DATE_FORMAT(date,"%Y")='=>$year,'DATE_FORMAT(date,"%c")='=>$month])->count();
        $page = new Paginator($cnf['paginator'],$max);
        $lim = $page->getLimits();
        $posts = Post::find()->where(['DATE_FORMAT(date,"%Y")='=>$year,'DATE_FORMAT(date,"%c")= '=>$month])->order([' `id` DESC '])->limit($lim[0],$lim[1])->all();
        return $this->view('post/archive',[
            'month'=>Post::getMonthName($month),
            'year'=>$year,
            'posts'=>$posts,
            'postArchive'=>Post::getArchieve(),
            'pgn'=>$page->render()
        ]);
    }
}