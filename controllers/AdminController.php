<?php
namespace app\controllers;
use app\src\Controller;
use app\src\Paginator;
use app\src\Registry;
use app\src\User;
use app\models\Post;
class AdminController extends Controller
{
    public function __construct(){
        parent::__construct();
        $user = new User();
        if(!$user->checkAuth()) header('Location: /login');
    }
    public function actionIndex(){
        return $this->view("admin/index");
    }


    public function actionPosts(){
        if(isset($_GET['message'])) $message = $_GET['message'];
        unset($_GET['message']);
        //------------------------------------------------------------------------------------------------
        $conf = Registry::get('config');
        $max = Post::find()->count();
        $pager = new Paginator($conf['paginator'],$max);
        $lim = $pager->getLimits();
        //------------------------------------------------------
        $posts = Post::find()->order(['`id` DESC'])->limit($lim[0],$lim[1])->all();
        return $this->view('admin/posts',['posts'=>$posts,'pgn'=>$pager->render(),'message'=>$message,'page'=>$pager->getCurrent()]);
    }


    public function actionCreate(){
        $post = null;
        if(!empty($_POST['name'])&& (!empty($_POST['message'])) ){
            $post = new Post();
            $post->name = htmlspecialchars($_POST['name']);
            $post->message = htmlspecialchars($_POST['message']);
            $post_id = $post->save();
            if($post_id) {
                header("Location:/post/edit/{$post_id}");
            }else $message = "Ошибка сохранения.Попробуйте еще раз";
        }
        return $this->view('admin/create',[
            "post"=>$post,
            "title"=>'Блог.Создание',
            "header"=>'Создание поста'
        ]);
    }
    public function actionEdit(){
        $id = $this->request->get('id');
        $post = Post::find()->where(["`id`="=>$id])->one();
        if(!empty($_POST['name'])&& (!empty($_POST['message'])) ){
            $post->name = htmlspecialchars($_POST['name']);
            $post->message = htmlspecialchars($_POST['message']);
            if($post->save()) {
                $message = "Пост отредактирован";
            }else $message = "Ошибка сохранения,сохраните еще раз";
        }
        return $this->view('admin/create',[
            'post'=>$post,
            "message"=>$message,
            "title"=>'Блог.Редактирование',
            "header"=>'Редактирование поста'
        ]);
    }
    public function actionDelete(){
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        if(isset($_POST['delete'])) $del = $_POST['delete'];

        // variant 1--begin// using static method
        $res = Post::multipleDel($del);
        $message = $res ? "&message=Посты удалены":"";
       //variant 1--end*/
        //variant 2--begin недостаток - множественный запрос на удаление -- можно закоментить и использовать вариант 1
        /*
        $res = Post::find()->where()->in('id',$del)->all();
        if(!empty($res))  foreach($res as $post) $post->delete();
        //variant 2--end*/
        header("Location:/posts?page=$page".$message);
    }
}