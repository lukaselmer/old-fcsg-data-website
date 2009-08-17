<?php

class AdminController extends ApplicationController {
    function before_filter() {
        if($_SESSION['authenticated']!=true) {
            redirect_to('users', 'login');
        }
    }

    function index() {
    //$this->players = $this->DB->select("select * from players order by position ASC");
        $this->players = $this->DB->select("select * from players order by last_name ASC");
        $this->open_player_id = intval($_REQUEST['open']);
    }

    function nnew() {
        $this->player = Array();
    }

    function create() {
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $inserted_id = $this->DB->insert("INSERT INTO `players` (
`first_name` ,
`last_name` ,
`description` ,
`nationality`,
`date_of_birth`,
`position`
)
VALUES (
\"".$player_params['first_name']."\",
\"".$player_params['last_name']."\",
\"".$player_params['description']."\",
\"".$player_params['nationality']."\",
\"".$player_params['date_of_birth']."\",
\"".Player::next_position()."\"
);");
        redirect_to('admin', 'index', Array('open' => $inserted_id));
    }

    function edit() {
        $this->player = $this->DB->select_by_id("players", $_REQUEST['id']);
    }

    function move_up() {
        $this->player = $this->DB->select_by_id("players", $_REQUEST['id']);
        $this->player_on_top = $this->DB->select_first("select * from players where `position` < \"".($this->player->position)."\" order by `position` DESC LIMIT 1");
        $this->switch_positions($this->player_on_top, $this->player);
        redirect_to('admin');
    }

    function move_down() {
        $this->player = $this->DB->select_by_id("players", $_REQUEST['id']);
        $this->player_on_top = $this->DB->select_first("select * from players where `position` > \"".($this->player->position)."\" order by `position` ASC LIMIT 1");
        $this->switch_positions($this->player_on_top, $this->player);
        redirect_to('admin');
    }

    function switch_positions($p1, $p2) {
        if($p1->id && $p2->id) {
            $this->DB->query("UPDATE `players` SET `position` = \"".($p1->position)."\" WHERE `id` = ".$p2->id.";");
            $this->DB->query("UPDATE `players` SET `position` = \"".($p2->position)."\" WHERE `id` = ".$p1->id.";");
        }
    }

    function update() {
        $player_params = $_REQUEST['player'];
        foreach ($player_params as $i => $param) {
            $player_params[$i] = str_replace('"', '&quot;', $param);
        }
        $this->DB->query("UPDATE `players` SET
`first_name` = \"".$player_params['first_name']."\",
`last_name` = \"".$player_params['last_name']."\",
`description` = \"".$player_params['description']."\",
`nationality` = \"".$player_params['nationality']."\",
`date_of_birth` = \"".$player_params['date_of_birth']."\"
WHERE `id` = ".intval($player_params['id'])." LIMIT 1 ;
");
        redirect_to('admin');
    }

    function destroy() {
        $player_id = $_REQUEST['id'];
        $this->DB->delete("DELETE FROM `players` WHERE `id` = ".intval($player_id)." LIMIT 1;");
        redirect_to('admin');
    }


    function edit_startpage_content() {
        $this->cms_content = $this->DB->select_by_attribute("cms_content", "cms_key", "startpage");
    }

    function update_startpage_content() {
        $params = $_REQUEST['cms_content'];
        foreach ($params as $i => $param) {
            $params[$i] = str_replace('"', '&quot;', $param);
        }
        $this->cms_content = $this->DB->select_by_attribute("cms_content", "cms_key", "startpage");
        $this->DB->query("UPDATE `cms_content` SET
`content` = \"".$params['content']."\"
WHERE `id` = ".$this->cms_content->id." LIMIT 1 ;
");
        redirect_to('admin');
    }

    function backup() {
        $this->backup_dir = BASE_DIR.SYSTEM_SLASH."backup".SYSTEM_SLASH.$this->backup_dir.date("Y-m-d_G-i-s");
        mkdir($this->backup_dir);
        chmod($this->backup_dir, "drwxrwxrwx");

        $this->csv_exports = Array();
        $res_tables = $this->DB->query("show tables;");

        while($row_table = mysql_fetch_array($res_tables)) {
            $table = $row_table[0];
            $this->csv_exports[$table] = Array();
            $this->csv_exports[$table][0] = Array();
            $res_fields = $this->DB->query("show columns from $table");
            while($row_field = mysql_fetch_row($res_fields)) {
                $this->csv_exports[$table][0][] = $row_field[0];
            }

            $fields = implode(",", $this->csv_exports[$table][0]);
            $res_objects = $this->DB->query("select $fields from $table");
            while($row_object = mysql_fetch_row($res_objects)) {
                $this->csv_exports[$table][] = $row_object;
            }
        }
    }
}

?>
