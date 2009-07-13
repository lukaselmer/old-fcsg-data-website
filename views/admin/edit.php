<? include "_tiny_mce_code.php" ?>

<form name="player" action="<? echo url_for('admin', 'update', Array(Array('id', $player->id))); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="player[id]" value="<? echo $player->id; ?>" />
    <fieldset>
        <legend>Spieler "<? echo $player->name ?>" bearbeiten</legend>
        <table>
            <tr>
                <td><label for="vorname">Name:</label></td>
                <td><input type="text" name="player[name]" value="<? echo $player->name; ?>" /></td>
            </tr>
            <tr>
                <td><label for="nachname">Beschreibung:</label></td>
                <td>
                    <textarea id="player[description]" name="player[description]" rows="8" cols="20"><? echo $player->description; ?></textarea>
                </td>
            </tr>
        </table>

        <input type="submit" value="Speichern" name="save" />
    </fieldset>
</form>
