<?php
class Session{
    public static function start():void
    {
        //si session demarré, ne rien faire
        if(session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        //si entetes imp ou incohérence etat declanché exption
        if(headers_sent() === true || session_status() === PHP_SESSION_DISABLED) {
            throw new SessionException();
        }
        //demarrer session 
        session_start();

    }
}