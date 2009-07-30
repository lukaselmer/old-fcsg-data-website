<?php

header("Location: /scripts/msd1.24/");
exit;

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