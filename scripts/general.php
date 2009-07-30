<?php

include('../config.php');
include('../lib/load.php');
include('../lib/connect_db.php');

include('../helpers/application_helper.php');
session_start();
if(!authenticate()){
    redirect_to('users', 'login');
}

?>
