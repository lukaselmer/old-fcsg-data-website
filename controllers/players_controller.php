<?php

class PlayersController extends ApplicationController{
    function index(){
        //$this->players = $this->DB->select("select * from players order by position ASC");
        $this->players = $this->DB->select("select * from players order by last_name ASC");
        $this->open_player_id = intval($_REQUEST['open']);
        $this->open_all = false || $_REQUEST['open_all'] == "1";
        $this->anchor_letters = Array();
        foreach ($this->players as $player) {
            $player_start_letter = ucfirst($player->last_name[0]);
            if(!in_array($player_start_letter, $this->anchor_letters)){
                $this->anchor_letters[] = $player_start_letter;
            }
        }
        //$this->anchor_letters = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ', 1);
        $this->startpage_content = $this->DB->select_by_attribute("cms_content", "cms_key", "startpage");
    }
}

?>
