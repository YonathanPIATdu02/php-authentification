<?php
class User{
    private $id; //string
    private $lastName; //string
    private $firstName; //string
    private $login; //string
    private $phone; //string
    const session_key = '__user__';

    private function __construct(){}
    
    public function firstname():string{
        return $this->firstName;
    }

    public function profile():string{
        return <<<HTML
        <p>Nom : {$this->lastName}</p>
        <p>Prénom : {$this->firstname}</p>
        <p>Login : {$this->login}</p>
        <p>telephone : {$this->phone}</p>
HTML;
    }
    
    public static function loginForm($action, $submitText = 'OK'):string{
        return <<<HTML
            <form method="GET" action="{$action}">
            <input name="login" type="text" placeholder="Login">
            <input name="mdp" type="text" placeholder="Mot de passe">
            
            <button type="submit">$submitTextpass</button>
HTML;
    }

    public static function createFromAuth(array $data): self
    {
        $stmt = MyPDO::getInstance()->prepare(<<<SQL
        SELECT *
        FROM user
        where login = :login 
        AND sha512pass = :sha512pass;
SQL
    );    
        $stmt->bindValue(':login', $data['login'], PDO::PARAM_STR);
        $stmt->bindValue(':sha512pass', hash("sha512",$data['mdp']), PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user == null)
        {
            $_SESSION[self::session_key]['connected'] = false;
            throw new AuthenticationException();
        }
        $_SESSION[self::session_key]['connected'] = true;
        return $user;
    }

    public static function isConnected(): bool
    {
        $_SESSION->start();
        return isset($_SESSION[self::session_key]['connected']) ? $_SESSION[self::session_key]["connected"] : false;
    }

    public static function logoutIfRequested(): void
    {
        $_SESSION->start();
        if (isset($_REQUEST["lougout"]))
        {
            $_session->start();
            unset($_SESSION[self::session_key]);
        }
    }
}