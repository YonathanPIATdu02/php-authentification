<?php
class SessionException extends Exception {
    public function __construct(string $message=""){
        if($message === ""){
            parent::__construct("erreur session");
        }
        else{
            parent::__construct($message);
        }
    }

}