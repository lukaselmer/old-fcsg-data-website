<?php

class DbClass{
    function select($query){
        $res = mysql_query($query);
        $objects = Array();
        while($object = mysql_fetch_object($res)){
            $objects[] = $object;
        }
        mysql_free_result($res);
        return $objects;
    }

}

$DB = new DbClass();


?>