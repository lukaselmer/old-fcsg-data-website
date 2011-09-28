<? include "_tiny_mce_code.php" ?>

<form name="cms_content" action="<? echo url_for('admin', 'update_journal_content'); ?>" method="POST" enctype="multipart/form-data">
    <fieldset>
        <legend>Inhalt der Journal bearbeiten</legend>
        <p>
            <label for="cms_content[content]">Inhalt</label>
            <textarea id="cms_content[content]" name="cms_content[content]" rows="8" cols="20"><? echo $cms_content->content; ?></textarea>
        </p>

        <input type="submit" value="Speichern" name="save" />
    </fieldset>
</form>
