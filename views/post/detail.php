<!--Заголовок-->
<? view_block("partials/header",['title'=>$post->name,"css"=>'style']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>$post->name]) ?>

<section class="section">
    <article class="article">
        <p class="post-content"><?= $post->message; ?></p>
    </article>
    <aside class="aside">
        <nav>
            <?view_block('partials/lastpost_link')?>
            <?view_block('partials/archive_nav',['postArchive'=>$postArchive])?>
        </nav>
    </aside>
</section>

<? view_block("partials/footer");?>