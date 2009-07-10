<?php

echo __FILE__;
echo "XXXXXX";

$path_parts = pathinfo(__FILE__);
echo $path_parts['dirname'], "\n";
echo "XXXXXX";
echo get_include_path();
echo "XXXXXX";
$new_include_path = "C:\\instantrails20\\php_apps\\fcsg-data\\";
set_include_path($new_include_path);

include('config.php');
include('lib/load.php');
include('lib/connect_db.php');
include('lib/request.php');


?>