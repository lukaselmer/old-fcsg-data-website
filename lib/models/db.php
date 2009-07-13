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

    function insert($query){
        mysql_query($query);
        return mysql_insert_id();
    }

    function update($query){
        mysql_query($query);
    }

    function delete($query){
        mysql_query($query);
    }
}

$DB = new DbClass();


?>