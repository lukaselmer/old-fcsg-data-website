<?php

echo __FILE__;
echo "XXXXXX";

$path_parts = pathinfo(__FILE__);
echo $path_parts['dirname'], "\n";
echo "XXXXXX";
echo get_include_path();
echo "XXXXXX";
#set_include_path(get_include_path() + ";" + $path_parts['dirname']);
set_include_path($path_parts['dirname']);

include('config.php');
include('lib/load.php');
include('lib/connect_db.php');
include('lib/request.php');


?>