<?# echo image_tag('border_top_grey.png'); ?>
<div class="players rounded">
    <div class="inner">
        <? foreach ($players as $player) { ?>

        <div style="height: 4px; width: 10px;"></div>
        <?# echo image_tag('border_top_white.png'); ?>
        <div class="player rounded" id="player_<? echo $player->id; ?>">
            <div class="inner">
                <div class="name" onclick="toggle_player_description(<? echo $player->id; ?>);"><b><? echo $player->name; ?></b></div>
                <div class="description" style="display:none;"><? echo $player->description; ?></div>
            </div>
        </div>
        <?# echo image_tag('border_bottom_white.png'); ?>

        <? } ?>

    <? link_to('test', '', 'nnew') ?>
    </div>
</div>
<?# echo image_tag('border_bottom_grey.png'); ?>
