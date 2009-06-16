<?php

include('./controllers/players_controller.php');
$controller = new PlayersController();
$controller->index();
$context = $controller;
foreach (get_object_vars($controller) as $k => $v) {
    $$k = $v;
}
include('./views/players/index.php');

?>
