<?php

class PlayersController extends ApplicationController{
    function index(){
        $this->players = $this->DB->select("select * from players");
        $this->open_player_id = intval($_REQUEST['open']);
    }
}

?>
