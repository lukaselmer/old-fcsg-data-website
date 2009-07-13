
<div class="players rounded">
    <div class="inner">
        
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded">
            <div class="inner">
                <div class="name">
                    <? link_to('Neuer Spieler', 'admin', 'nnew'); ?>
                </div>
            </div>
        </div>

        <? foreach ($players as $player) { ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded" id="player_<? echo $player->id; ?>">
            <div class="inner">
                <div class="name">
                    <div class="fl" onclick="toggle_player_description(<? echo $player->id; ?>);"><b><? echo $player->name; ?></b></div>
                    <div class="fr"><? link_to('bearbeiten', 'admin', 'edit', Array(Array('id', $player->id))); ?>
                    <? link_to('löschen', 'admin', 'destroy', Array('id' => $player->id), Array('onclick' => "return confirm('Wirklich löschen?');")); ?></div>
                    <? clearer(); ?>
                </div>
                <div class="description" style="<? echo $open_player_id == $player->id ? '' : 'display:none;' ?>">
                    <? echo htmlspecialchars_decode($player->description); ?>
                </div>

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
