<h1>
    Kontaktformular
</h1>

<? if($error){
    echo "<p><i><b>$error</b></i></p>";
} ?>

<form action="<? echo url_for('home', 'contact'); ?>" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Ihr Name (min. 4 Zeichen):</td>
            <td><input type="text" name="name" value="<? echo $_REQUEST['name']; ?>" /></td>
        </tr>
        <tr>
            <td>Ihre Email-Adresse (gültige Email):</td>
            <td><input type="text" name="email" value="<? echo $_REQUEST['email']; ?>" /></td>
        </tr>
        <tr>
            <td>Betreff (min. 4 Zeichen):</td>
            <td><input type="text" name="subject" value="<? echo $_REQUEST['subject']; ?>" /></td>
        </tr>
        <tr>
            <td>Nachricht (min. 10 Zeichen):<br></td>
            <td><textarea cols="40" rows="10" name="message"><? echo $_REQUEST['message']; ?></textarea></td>
        </tr>
        <!--<tr>
            <?
            //$num1 = rand(1, 4);
            //$num2 = rand(1, 4);
            ?>
            <td>Was gibt <? echo $num1; ?> + <? echo $num2; ?> ?:<br></td>
            <td>
                <input type="hidden" name="solution" value="<?echo $num1 + $num2; ?>" />
                <input type="text" name="question" value="" />
            </td>
        </tr>-->
        <tr>
            <td></td>
            <td>
                <input type="submit" value="Senden" name="submit" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="send" value="1" />
</form> 