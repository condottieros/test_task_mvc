<?php foreach($posts as $post):?>
    <div class="post-shortly">
        <h2 class="post-shortly__name"><a href="/post/<?= $post->id; ?>"><?= $post->name; ?></a></h2>
        <time><?= form_date($post->date); ?></time>
    </div>
<?endforeach?>