<?php

class ApplicationController {
    public function __construct() {
        global $DB;
        $this->DB = $DB;
        $this->before_filter();
    }
    
    function before_filter(){}

    function layout($name = 'base'){
        
    }

    function index(){
    }

    function nnew(){

    }

    function create(){

    }

    function edit(){

    }

    function update(){

    }

    function delete(){

    }
}

?>
