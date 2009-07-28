<? include "_tiny_mce_code.php" ?>

<form name="player" action="<? echo url_for('admin', 'update', Array(Array('id', $player->id))); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="player[id]" value="<? echo $player->id; ?>" />
    <fieldset>
        <legend>Spieler "<? echo $player->first_name ?>" bearbeiten</legend>
        <? include "_formfields.php"; ?>
    </fieldset>
</form>
