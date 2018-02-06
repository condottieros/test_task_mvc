<!--Заголовок-->
<? view_block("partials/header",['title'=>"Административный раздел","css"=>'admin']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>"Административный раздел"]) ?>

<section class="section">
    <article class="article">
        <ul class="admin-main-menu">
            <li class="admin-main-menu__item">
                <a href="/posts"  class="admin-main-menu__item-a">Список постов <br />≡</a>
            </li>
            <li class="admin-main-menu__item">
                <a href="/post/create"  class="admin-main-menu__item-a">Создать пост <br />&#10548;</a>
            </li>
        </ul>
    </article>
    <aside class="aside">
        <nav>
            <?view_block('partials/admin_nav')?>
        </nav>
    </aside>
</section>


<footer>&copy; <a href="http://cetera.ru">Cetera labs</a> 2013</footer>
<s cript type="text/javascript" src="http://yandex.st/jquery/2.0.3/jquery.min.js"></s cript>
<s cript type="text/javascript" src="/web/admin.js"></s cript>
</body>
</html>
