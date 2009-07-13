<?php

class AdminController extends ApplicationController{
    function index(){
        $this->players = $this->DB->select("select * from players");
    }

    function nnew(){

    }

    function create(){
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $this->DB->insert("INSERT INTO `players` (
`name` ,
`description`
)
VALUES (
\"".$player_params['name']."\",
\"".$player_params['description']."\"
);");
    }

    function edit(){

    }

    function update(){
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $this->DB->insert("UPDATE `players` SET
`name` = \"".$player_params['name']."\",
`description` = \"".$player_params['description']."\"
WHERE `id` = ".intval($player_params['id'])." LIMIT 1 ;
");
    }

    function delete(){
        $player_params = $_REQUEST['id'];
        $this->DB->delete("DELETE FROM `players` WHERE `id` = ".intval($player_params['id'])." LIMIT 1;");
    }
}

?>
