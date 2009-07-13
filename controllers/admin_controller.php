<?php

class AdminController extends ApplicationController{
    function index(){
        $this->players = $this->DB->select("select * from players");
        $this->open_player_id = intval($_REQUEST['open']);
    }

    function nnew(){
        $this->player = Array();
    }

    function create(){
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $inserted_id = $this->DB->insert("INSERT INTO `players` (
`name` ,
`description`
)
VALUES (
\"".$player_params['name']."\",
\"".$player_params['description']."\"
);");
        redirect_to('admin', 'index', Array('open' => $inserted_id));
    }

    function edit(){
        $this->player = $this->DB->select_first("select * from players where id = ".intval($_REQUEST['id']));
    }

    function update(){
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $this->DB->update("UPDATE `players` SET
`name` = \"".$player_params['name']."\",
`description` = \"".$player_params['description']."\"
WHERE `id` = ".intval($player_params['id'])." LIMIT 1 ;
");
        redirect_to('admin');
    }

    function destroy(){
        $player_params = $_REQUEST['id'];
        $this->DB->delete("DELETE FROM `players` WHERE `id` = ".intval($player_params['id'])." LIMIT 1;");
        redirect_to('admin');
    }
}

?>
