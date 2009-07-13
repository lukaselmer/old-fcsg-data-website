<? include "_tiny_mce_code.php" ?>

<form name="player" action="<? echo url_for('admin', 'update', Array(Array('id', $player->id))); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="player[id]" value="<? echo $player->id; ?>" />
    <fieldset>
        <legend>Spieler "<? echo $player->name ?>" bearbeiten</legend>
        <p>
            <label for="player[name]">Name</label>
            <input type="text" id="player[name]" name="player[name]" value="<? echo $player->name; ?>" />
        </p>

        <p>
            <label for="player[description]">Beschreibung</label>
            <textarea id="player[description]" name="player[description]" rows="8" cols="20"><? echo $player->description; ?></textarea>
        </p>

        <input type="submit" value="Speichern" name="save" />
    </fieldset>
</form>
