<?php
require_once('autoload.include.php') ;

//acces autorisé
if (User::isConnected())
{
    $p->appendContent(<<<HTML
    <div>Salut {$user->firstName()}</div>
HTML
) ;
}


//redirection a au formulaire
else
{
    header ("Location: form2.php");
    die();

}