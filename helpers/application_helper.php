<?php

function link_to($name, $controller, $action){
    if(!$controller || $controller == ""){ $controller = $_GET['controller'];}
    if(!$action || $action == ""){ $action = $_GET['action'];}
    $url = "?controller=$controller&action=$action";
    return "<a href=\"$url\">$name</a>";
}

?>
