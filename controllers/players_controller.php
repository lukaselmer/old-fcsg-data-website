<?php

class PlayersController extends ApplicationController{
    function index(){
        $this->players = $this->DB->select("select * from players");
    }
}

?>
