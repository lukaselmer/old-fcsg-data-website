<?php


include('../config.php');
include('../lib/load.php');
include('../lib/connect_db.php');


include('../helpers/application_helper.php');
session_start();
if(!authenticate()){
    redirect_to('users', 'login');
}

if($_REQUEST['confirm'] != "1"){
    echo "<a href='/scripts/reset_db.php?confirm=1'>Hiermit wird die ganze Datenbank zurückgesetzt. Alle Spieler werden gelöscht! Fortfahren?</a>";
    exit;
}

echo "Funktion durch Admin deaktiviert. Sorry!";
exit;
$str = trim(file_get_contents('reset.sql'));
$str = str_replace("#{DB_NAME}", $cfg['mysql']['database'], $str);
$file_content = split(";", $str);
echo "<pre>";
foreach($file_content as $sql_line){
    $sql_line = trim($sql_line);
    echo $sql_line . "\n";
    if($sql_line != ""){
        mysql_query($sql_line);
    }
}
echo "</pre>";

?>