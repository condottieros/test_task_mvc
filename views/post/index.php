<!--Заголовок-->
<? view_block("partials/header",['title'=>"Блог гениального автора","css"=>'style']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>"Блог гениального автора"]) ?>

<section class="section">
    <article class="article">
       <?view_block('partials/post_list',['posts'=>$posts])?>
    </article>
    <aside class="aside">
        <nav>
            <? view_block("partials/lastpost_link")?>
            <? view_block("partials/archive_nav",["postArchive"=>$postArchive])?>
        </nav>
    </aside>
</section>

<div><?=$pgn?></div>
<? view_block("partials/footer");?>
