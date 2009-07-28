
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
                    <!-- <div class="fl">
    < ? link_to(image_tag('icons/up.gif', false), 'admin', 'move_up', Array('id' => $player->id)); ?>
    < ? link_to(image_tag('icons/down.gif', false), 'admin', 'move_down', Array('id' => $player->id)); ?>
    &nbsp;
    </div> -->
                    <div class="fl" onclick="toggle_player_description(<? echo $player->id; ?>);">
                        <? echo $player->first_name; ?> <b><? echo $player->last_name; ?></b>
                    </div>
                    <div class="fr"><? link_to('bearbeiten', 'admin', 'edit', Array(Array('id', $player->id))); ?>
                    <? link_to('löschen', 'admin', 'destroy', Array('id' => $player->id), Array('onclick' => "return confirm('Wirklich löschen?');")); ?></div>
                    <? clearer(); ?>
                </div>
                <div class="description" style="<? echo $open_player_id == $player->id ? '' : 'display:none;' ?>">
                    <p>
                        <i>
                            * <? echo $player->date_of_birth; ?>
                            <? if($player->nationality != ''){ ?>
                            | Nationalität: <?php echo $player->nationality ?>
                            <? } ?>
                        </i>

                    </p>
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
