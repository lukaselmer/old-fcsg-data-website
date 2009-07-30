<?php

include('general.php');

$tableName  = 'players';
$backupFile = getcwd().'/backup/mypet.sql';
$backupFile = 'C:/instantrails20/php_apps/fcsg-data/scripts/backup/mypeta.sql';
$query      = "SELECT * INTO DUMPFILE '$backupFile' FROM $tableName";
$result = mysql_query($query);

/*$str = trim(file_get_contents('reset.sql'));
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
echo "</pre>";*/

?>