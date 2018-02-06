
<?php if(!empty($postArchive)):?>
    <h2 class="arch-nav-header">Архив постов</h2>
    <ul class="arch-menu">
        <?php   foreach($postArchive as $archiveItem):?>
            <li class="arch-menu__item">
                <a href="/archive/<?= $archiveItem['year']; ?>/<?= $archiveItem['month']; ?>"><?= $archiveItem['month_name']; ?> <?= $archiveItem['year']; ?></a>
            </li>
        <?endforeach?>
    </ul>
<?endif?>