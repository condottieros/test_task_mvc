<!--Заголовок-->
<? view_block("partials/header",['title'=>$title,"css"=>'admin']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>$header]) ?>

<section class="section">
    <article class="article">
        <?= $message; ?>
        <form class="form" action="" method="post">
            <div class="form__group">
                <label for="name"  class="form__label">Название:</label>
                <input type="text" id="name" name="name" value="<?= $post->name; ?>" class="form__input"/>
            </div>
            <div class="form__group">
                <label for="message"  class="form__label">Сообщение:</label>
                <textarea name="message" id="message" cols="30" rows="10" class="form__input"><?= $post->message; ?></textarea>
            </div>
            <div class="form__group">
                <button type="submit" class="submit-btn">Сохранить</button>
            </div>
        </form>
    </article>
    <aside class="aside">
        <nav>
           <? view_block('partials/admin_nav') ?>
        </nav>
    </aside>
</section>

<?view_block('partials/footer')?>