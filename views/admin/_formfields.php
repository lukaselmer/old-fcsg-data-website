<p>
    <label for="player[first_name]">Vorname</label>
    <input type="text" id="player[first_name]" name="player[first_name]" value="<? echo $player->first_name; ?>" />
</p>

<p>
    <label for="player[last_name]">Nachname</label>
    <input type="text" id="player[last_name]" name="player[last_name]" value="<? echo $player->last_name; ?>" />
</p>

<p>
    <label for="player[nationality]">Nationalität</label>
    <input type="text" id="player[nationality]" name="player[nationality]" value="<? echo $player->nationality; ?>" />
</p>

<p>
    <label for="player[date_of_birth]">Geburtsdatum oder Geburtsjahr</label>
    <input type="text" id="player[date_of_birth]" name="player[date_of_birth]" value="<? echo $player->date_of_birth; ?>" />
</p>

<p>
    <label for="player[description]">Beschreibung</label>
    <textarea id="player[description]" name="player[description]" rows="8" cols="20"><? echo $player->description; ?></textarea>
</p>

<input type="submit" value="Speichern" name="save" />
