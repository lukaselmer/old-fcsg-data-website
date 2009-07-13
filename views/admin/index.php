


<div class="players rounded">
    <div class="inner">
        <? foreach ($players as $player) { ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded" id="player_<? echo $player->id; ?>">
            <div class="inner">
                <div class="name">
                    <div class="fr"><? link_to('Spieler bearbeiten', 'admin', 'edit', Array(Array('id', $player->id))); ?></div>
                    <div class="fl" onclick="toggle_player_description(<? echo $player->id; ?>);"><b><? echo $player->name; ?></b></div>
                    <? clearer(); ?>
                </div>
                <div class="description" style="display:none;"><? echo htmlspecialchars_decode($player->description); ?></div>
            </div>
        </div>
        <? } ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded">
            <div class="inner">
                <div class="name">
                    <? link_to('Neuer Spieler', 'admin', 'nnew'); ?>
                </div>
            </div>
        </div>

    </div>
</div>

