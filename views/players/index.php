
<div class="players rounded">
    <div class="inner">
        <? include "_startpage_content.php"; ?>

        <? include "_player_index.php"; ?>

        <? $startchar = ''; //startchar is needed for the alphabethic grouping ?>
        <? foreach ($players as $player) {
            if($startchar != ucfirst($player->last_name[0])) {
                $startchar = ucfirst($player->last_name[0]); ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded">
            <div class="inner">
                <a name="players-<? echo $startchar ?>" href="#players-<? echo $startchar ?>" style="text-decoration:none;">
                    <em><? echo $startchar ?></em>
                </a>
            </div>
        </div>
        <? } ?>
        <div style="height: 4px; width: 10px;"></div>
        <div class="player rounded" id="player_<? echo $player->id; ?>">
            <div class="inner">
                <div class="name" onclick="toggle_player_description(<? echo $player->id; ?>);">
                    <a style="text-decoration:none;" onclick="return false;" href="?controller=players&open=<? echo $player->id; ?>">
                        <? echo $player->first_name; ?> <b><? echo $player->last_name; ?></b>
                    </a>
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

        <? include "_player_index.php"; ?>

    </div>
</div>
