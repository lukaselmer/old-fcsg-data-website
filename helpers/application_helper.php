<?php

function link_to($name, $controller, $action = 'index', $url_params=Array(), $print=true){
    if(!$controller || $controller == ""){ $controller = $_GET['controller'];}
    if(!$action || $action == ""){ $action = $_GET['action'];}
    $url = "?controller=$controller&action=$action";
    if(sizeof($url_params) > 0){
        foreach ($url_params as $url_param) {
            $url .= '&'.$url_param[0].'='.$url_param[1];
        }
    }
    $str = "<a href=\"$url\">$name</a>";
    if($print){ echo $str; }
    return $str;
}

function image_tag($img, $print=true){
    $alt = split($img, '.'); $alt = $alt[0];
    $str = "<img src=\"/public/images/$img\" alt=\"$alt\" />";
    if($print){ echo $str; }
    return $str;
}

function clearer($print=true){
    $str = '<div class="clearer"></div>';
    if($print){ echo $str; }
    return $str;
}

?>
