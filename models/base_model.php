<?php

class BaseModel{
    public function __construct() {
        global $DB;
        $this->DB = $DB;
    }

    public static function DB(){
        global $DB;
        return $DB;
    }


}

?>
