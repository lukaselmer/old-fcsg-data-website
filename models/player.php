<?php

class Player extends BaseModel{

    static function next_position(){
        return self::DB()->max("players" , "position") + 1;
    }

}

?>
