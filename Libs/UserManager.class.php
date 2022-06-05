<?php
class UserManager
{
    private static $_instance;
    private static $_pdo;

    private function __construct()
    {
        self::$_pdo = DBConnection::getInstance();
    }

    public static function getInstance(): Object
    {
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function getUsers()
    {
        $users = self::$_pdo->query("SELECT * FROM `user`")->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }

    public function addUser(User $user)
    {
        $request = self::$_pdo->prepare("INSERT INTO `user` SET `pseudo`=:nam, `password`=:passwd");
        $request->bindValue(':nam', $user->getName());
        $request->bindValue(':passwd', $user->getHashedPassword());

        try{
            $request->execute();
        }
        catch(PDOException $pe){
            echo "ERREUR : " . $pe->getMessage();
            exit;
        }
    }
}