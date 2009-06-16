<?php

$contrller_name = $_GET['controller'] ? $_GET['controller'] : 'players';
$action_name = $_GET['action'] ? $_GET['action'] : 'index';

$_GET['controller'] = $contrller_name;
$_GET['action'] = $action_name;

include('controllers/'.$contrller_name.'_controller.php');

$big_controller_name = ucfirst($contrller_name)."Controller";
$controller = new $big_controller_name();
$controller->$action_name();
foreach (get_object_vars($controller) as $k => $v) {
    $$k = $v;
}

include('helpers/application_helper.php');
include('views/'.$contrller_name.'/'.$action_name.'.php');

?>
