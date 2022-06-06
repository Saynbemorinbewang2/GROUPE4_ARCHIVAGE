<?php

class DBConnection
{
    private static $pdo;
    private static $DATABASE = 'archivage';

    private function __construct()
    {
        $DSN = "mysql:host=localhost;dbname=" . self::$DATABASE;
        $USERNAME = 'root';
        $PASSWD = '';
        
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try{
            self::$pdo = new PDO($DSN, $USERNAME, $PASSWD, $options);
        }catch(PDOException $pe){
            echo "ERREUR DANS LORS DE LA CREATION DE LA DB";
            echo $pe->getMessage();
            exit;
        }
    }

    public static function getInstance() : Object
    {
        if(!(self::$pdo instanceof self))
            new self;

        return self::$pdo;
    }
}