<?php

class HomeController extends ApplicationController{
    function contact(){
        if($_REQUEST['send'] == 1){ //If form filled out...
            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $subject = $_REQUEST['subject'];
            $message = $_REQUEST['message'];
            //check form imput
            if(strlen($name) >= 4 && strlen($subject) >= 4 && strlen($message) >= 10 && valid_email($email)){
                $email_body = "Name: $name\n
                Email: $email\n
                Betreff: $subject\n
                Nachricht: $message";
                try {
                    if(!@mail('lukas.elmer@gmail.com, xxxbeathaueter@bluewin.ch', "Kontaktformular FCSG-Data", $email_body)){
                        redirect_to('home', 'send_error');
                    }
                } catch (Exception $e) {
                    redirect_to('home', 'send_error');
                }
                redirect_to('home', 'contact_sent');
            } else {
                $this->error = "Bitte füllen Sie das Formular bitte korrekt aus.";
            }

        }
    }

    function contact_sent(){}
    function send_error(){}
}

?>
