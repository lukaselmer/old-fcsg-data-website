
<ul>
    <?php
    foreach ($players as $player) {
        echo sprintf("<li>%s</li>", $player->name);
    }
    echo link_to('test', '', 'nnew')
    ?>
</ul>
