<?php

include('controllers/application_controller.php');

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

if($stop_output){
    if($final_output){
        echo $final_output;
    }
}
else {
    include('helpers/application_helper.php');
    ob_start();
    include('views/'.$contrller_name.'/'.$action_name.'.php');
    $view_content = ob_get_contents();
    ob_end_clean();

    if(!$layout){
        $layout = 'base';
    }
    include("views/layouts/$layout.php");
}



?>
