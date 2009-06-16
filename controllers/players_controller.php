<?php

class PlayersController{
    function index(){
        global $DB;
        $this->players = $DB->select("select * from players");
    }

    function nnew(){

    }

    function create(){

    }

    function edit(){

    }

    function update(){

    }

    function delete(){

    }
}

?>
