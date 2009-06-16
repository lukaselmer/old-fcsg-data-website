
<ul>
    <?php
    foreach ($players as $player) {
        echo sprintf("<li>%s</li>", $player->name);
    }
    ?>
</ul>
