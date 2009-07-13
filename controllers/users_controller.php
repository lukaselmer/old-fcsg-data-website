<?php

class UsersController extends ApplicationController{

    /*function  __construct() {
        $this->users = Array('beat' => 'motocross', 'lukas' => 'motocross');
    }*/

    function index(){
        redirect_to('', 'login');
    }

    function login(){
        $this->login_failed = false;
        if($_REQUEST['login']){
            if(authenticate($_REQUEST['user']['name'], $_REQUEST['user']['password'])){
                redirect_to('admin');
            } else {
                $this->login_failed = true;
            }
        }
    }

    function logout(){
        session_destroy();
        redirect_to('players');
    }
}

?>
