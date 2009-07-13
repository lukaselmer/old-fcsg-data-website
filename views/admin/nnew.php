<? include "_tiny_mce_code.php" ?>

<form name="player" action="<? echo url_for('admin', 'create'); ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Neuer Spieler</legend>
        <table>
            <tr>
                <td><label for="vorname">Name:</label></td>
                <td><input type="text" name="player[name]" value="" /></td>
            </tr>
            <tr>
                <td><label for="nachname">Beschreibung:</label></td>
                <td>
                    <textarea id="player[description]" name="player[description]" rows="8" cols="20">
                    </textarea>
                </td>
            </tr>
        </table>

        <input type="submit" value="Speichern" name="save" />
    </fieldset>
</form>
