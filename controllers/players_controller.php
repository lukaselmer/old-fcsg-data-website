<?php

class PlayersController{
    function index(){
        global $DB;
        $this->players = $DB->select("select * from players");
    }
}

?>
