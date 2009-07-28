<?php

function valid_email($email) {
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
        //list($username,$domain)=split('@',$email);
        return true;
    }
    return false;
}
    
function authenticate($entered_username = '', $entered_password = ''){
    if($_SESSION['authenticated']){
        return true;
    }
    $users = Array('beat' => 'motocross', 'lukas' => 'motocross');
    foreach ($users as $username => $password) {
        if($entered_username == $username && $entered_password == $password){
            $_SESSION['authenticated'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            return true;
        }
    }
    return false;
}

function link_to($name, $controller, $action = 'index', $url_params=Array(), $html_params=Array(), $print=true){
    $url = url_for($controller, $action, $url_params);
    if(sizeof($html_params) > 0){
        $html_params_str = "";
        foreach ($html_params as $k => $v) {
            $v = str_replace('"', "\\\"", $v);
            $html_params_str .= " $k=\"$v\"";
        }
    }
    $str = "<a href=\"$url\"$html_params_str>$name</a>";
    if($print){ echo $str; }
    return $str;
}

function image_tag($img, $print=true){
    $alt = split('\.', $img); $alt = ucwords($alt[0]);
    $str = "<img src=\"/public/images/$img\" alt=\"$alt\" />";
    if($print){ echo $str; }
    return $str;
}

function clearer($print=true){
    $str = "<div class=\"clearer\"></div>\n";
    if($print){ echo $str; }
    return $str;
}

function aggregate_url_params($url_params){
    if(is_array($url_params[0])){
        $new_url_params = Array();
        foreach ($url_params as $url_param) {
            $new_url_params[$url_param[0]] = $url_param[1];
        }
        $url_params = $new_url_params;
    }
    return $url_params;
}

function url_for($controller, $action = 'index', $url_params=Array()){
    $url_params = aggregate_url_params($url_params);
    if(!$controller || $controller == ""){ $controller = $_GET['controller'];}
    if(!$action || $action == ""){ $action = $_GET['action'];}
    $url = "/?controller=$controller&action=$action";
    if(sizeof($url_params) > 0){
        foreach ($url_params as $key => $value) {
            $url .= '&'.$key.'='.$value;
        }
    }
    return $url;
}

function redirect_to($controller, $action = 'index', $url_params=Array()){
    header("Location: ".url_for($controller, $action, $url_params));
    exit;
}

?>
