<?php

$con = mysql_connect($cfg['mysql']['host'], $cfg['mysql']['username'], $cfg['mysql']['password']);
mysql_query("set names 'utf8';");
mysql_select_db($cfg['mysql']['database']);

?>
