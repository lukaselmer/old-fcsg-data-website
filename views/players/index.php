<div class="players rounded">
    <div class="inner">
        <? foreach ($players as $player) { ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded" id="player_<? echo $player->id; ?>">
            <div class="inner">
                <div class="name" onclick="toggle_player_description(<? echo $player->id; ?>);">
                    <b><a style="text-decoration:none;" onclick="return false;" href="?controller=players&open=<? echo $player->id; ?>"><? echo $player->name; ?></a></b>
                </div>
                <div class="description" style="<? echo $open_player_id == $player->id ? '' : 'display:none;' ?>"><? echo htmlspecialchars_decode($player->description); ?></div>
            </div>
        </div>
        <? } ?>
    </div>
</div>
