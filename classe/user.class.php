<?php
class User{
    private $id; //string
    private $lastName; //string
    private $firstName; //string
    private $login; //string
    private $phone; //string

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
    
    public function loginForm($action, $submitText = 'OK'):string{
        return <<<HTML
            <form method="GET" action="{$action}">
            <input name="login" type="text" placeholder="Login">
            <input name="mdp" type="text" placeholder="Mot de passe">
            
            <button type="submit">$submitTextpass</button>
HTML;
    }
    public function createFromAuth(array $data){
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

        if ($user == null){
            throw new AuthenticationException();
        }

        return $user;
    }

}