<?php

class PlayersController extends ApplicationController{
    function index(){
        //$this->players = $this->DB->select("select * from players order by position ASC");
        $this->players = $this->DB->select("select * from players order by last_name ASC");
        $this->open_player_id = intval($_REQUEST['open']);
    }
}

?>
