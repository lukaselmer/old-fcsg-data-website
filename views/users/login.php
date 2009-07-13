<? if($login_failed){
    echo "Login fehlgeschlagen. Bitte prüfe die eingegebenen Daten.";
} ?>

<form name="login" action="<? echo url_for('users', 'login'); ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Login</legend>
        <p>
            <label for="user[name]">Benutzername</label>
            <input type="text" id="user[name]" name="user[name]" value="" />
        </p>
        <p>
            <label for="user[password]">Passwort</label>
            <input type="password" id="user[password]" name="user[password]" />
        </p>

        <input type="submit" value="Login" name="login" />
    </fieldset>
</form>


