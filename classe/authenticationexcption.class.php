<?php
class AuthenticationException extends Exception {
    public function __construct(string $message=""){
        if($message === ""){
            parent::__construct("erreur Authentication");
        }
        else{
            parent::__construct($message);
        }
    }

}