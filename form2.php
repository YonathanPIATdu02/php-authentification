<?php
require_once('autoload.include.php') ;
if (User::isConnected())
{
    $p = new WebPage('Authentification') ;
    $form = User::logoutForm('','deco');
    $p->appendContent(<<<HTML
    {$form}
HTML);
}

else
{ 
    $p = new WebPage('Authentification');

    // Production du formulaire de connexion
    $p->appendCSS(<<<CSS
        form input {
            width : 4em ;
        }
    CSS
    ) ;
    $form = User::loginForm('auth1.php') ;
    $p->appendContent(<<<HTML
        {$form}
        <p>Pour faire un test : toto/titi
HTML
);
    
    echo $p->toHTML();
}


