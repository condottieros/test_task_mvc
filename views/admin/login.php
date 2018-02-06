<!--Заголовок-->
<? view_block("partials/header",['title'=>"Блог.Авторизация","css"=>'admin']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>"Авторизация"]) ?>

<section class="section">
    <article class="article">
        <?= $message; ?>
        <form action="" method="post" class="form">
            <div class="form__group">
                <label for="login" class="form__label">Логин:</label>
                <input type="text" id="login" name="login" value="" class="form__input"/>
            </div>
            <div class="form__group">
                <label for="pass">Пароль:</label>
                <input type="text" id="pass" name="pass" value="" class="form__input"/></div>
            <div class="form__group">
                <button type="submit" class="submit-btn">Войти</button>
            </div>
        </form>
    </article>
    <!---------------------------------------------------------------------------->
    <aside class="aside">
        <nav>
            <!---->
        </nav>
    </aside>
    <!---------------------------------------------------------------------------->
</section>

<?view_block('partials/footer')?>