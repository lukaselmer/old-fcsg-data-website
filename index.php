<?php

$path_parts = pathinfo(__FILE__);
set_include_path(get_include_path().";".$path_parts['dirname']);

include('config.php');
include('lib/load.php');
include('lib/connect_db.php');
include('lib/request.php');


?>