<?php

class PlayersController extends ApplicationController{
    function index(){
        $this->players = $this->DB->select("select * from players");
    }

    function nnew(){

    }

    function create(){
        $this->DB->select("select * from players");
    }

    function edit(){

    }

    function update(){

    }

    function delete(){

    }
}

?>
