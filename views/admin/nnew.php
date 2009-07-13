<? include "_tiny_mce_code.php" ?>

<form name="player" action="<? echo url_for('admin', 'create'); ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Neuer Spieler</legend>
        <p>
            <label for="player[name]">Name</label>
            <input type="text" id="player[name]" name="player[name]" value="" />
        </p>

        <p>
            <label for="player[description]">Beschreibung</label>
            <textarea id="player[description]" name="player[description]" rows="8" cols="20"></textarea>
        </p>

        <input type="submit" value="Speichern" name="save" />
    </fieldset>
</form>
