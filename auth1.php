<?php
require_once('autoload.include.php') ;

$p = new WebPage('Authentification') ;

try {
    // Tentative de connexion
    $user = User::createFromAuth($_REQUEST) ;
    $p->appendContent(<<<HTML
<div>Salut {$user->firstName()}</div>
HTML
) ;
}
catch (AuthenticationException $e) {
    // Récuperation de l'exception si connexion échouée
    $p->appendContent("Échec d'authentification&nbsp;: {$e->getMessage()}") ;
}
catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}") ;
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML() ;