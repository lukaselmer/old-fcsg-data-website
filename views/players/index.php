<? echo image_tag('border_top.png'); ?>
<div class="players" id="player_<? echo $player->id ?>">
    <? foreach ($players as $player) { ?>
    <div class="player">
        <div class="name" onclick="toggle_player(<? echo $player->id ?>);"><b><? echo $player->name; ?></b></div>
        <div class="description" style="display:none;"><? echo $player->description; ?></div>
    </div>
    <? } ?>

<? echo link_to('test', '', 'nnew') ?>
</div>
<? echo image_tag('border_bottom.png'); ?>
