<!--Заголовок-->
<? view_block("partials/header",['title'=>"Список постов","css"=>'admin']) ?>
<!--Шапка-->
<? view_block("partials/hat",['hat'=>'Список постов']) ?>

<section class="section">
    <article class="article">
        <?= $message; ?>
        <form action="/post/delete?page=<?=$page?>" method="post">
            <input type="hidden" name="save" value="1" />

            <table  class="admin-postlist">
                <thead>
                <tr>
                    <th class="admin-postlist__cell">#</th>
                    <th class="admin-postlist__cell">Название</th>
                    <th class="admin-postlist__cell">Дата</th>
                    <th class="admin-postlist__cell"><label>Выбрать <br /> <input type="checkbox" id="deleteAll" value="" /></label></th>
                </tr>
                </thead>
                <?php
                foreach($posts as $post):
                    ?>
                    <tr>
                        <td class="admin-postlist__cell"><?= $post->id; ?></td>
                        <td class="admin-postlist__cell"><a href="/post/edit/<?=$post->id;?>"><?= $post->name; ?></a></td>
                        <td class="admin-postlist__cell"><?= form_date($post->date); ?></td>
                        <td class="admin-postlist__cell"><input class="del_chkbox" type="checkbox" name="delete[]" value="<?= $post->id; ?>" /></td>
                    </tr>
                    <? endforeach ?>
                    <input name="page" type="hidden" value="<?=$page?>"/>
                <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="admin-postlist__cell fcell">
                        <button type="submit" class="submit-btn">Удалить</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </article>
    <aside class="aside">
        <nav>
            <?view_block('partials/admin_nav')?>
        </nav>
    </aside>
</section>

<div><?=$pgn?></div>
<?view_block('partials/footer')?>
<script type="text/javascript" src="http://yandex.st/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript" src="/web/admin.js"></script>