<?php

class User
{
    private $_name;
    private $_password1;
    private $_password2;

    public function __construct(){}

    public function hydrate(array $info)
    {
        foreach($info as $key => $data){
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($data);
            }
        }
    }

    public function getName(){ return $this->_name; }
    public function getPassword1() { return $this->_password1; }
    public function getPassword2() { return $this->_password2; }        
    public function getHashedPassword(){ return password_hash($this->getPassword1(), PASSWORD_BCRYPT); }

    public function setName($name)
    {
        if(is_string($name)){
            $name = htmlspecialchars($name);
            $this->_name = $name;
        }
    }
    public function setPassword1($password)
    {
        if(is_string($password)){
            $password = htmlspecialchars($password);
            $this->_password1 = $password;
        }
    }
    public function setPassword2($password)
    {
        if(is_string($password)){
            $password = htmlspecialchars($password);
            $this->_password2 = $password;
        }
    }

    public function isValidName(): bool
    {
        if(is_string($this->getName()) && strlen($this->getName()) > 1)
            return true;
    
        return false;
    }
    public function isValidPassword(): bool
    {
        if((strlen($this->getPassword1()) < 8) || $this->getPassword1() !== $this->getPassword2())
            return false;

        return true;
    }
    public function isValidUser()
    {
        if($this->isValidName() && $this->isValidPassword())
            return true;

        return false;
    }
    public function getErrors(): array
    {
        $errors = [];

        if(!$this->isValidName()){
            $errors['name'] = "Le nom d'utilisateur est trop court";
        }
        if(!$this->isValidPassword()){
            if(strlen($this->getPassword1()) < 8)
                $errors['password1'] = "Mot de passe tres courp. Entrez au moins 8 caracteres";
            if($this->getPassword1() !== $this->getPassword2())
                $errors['password2'] = "Les mots de passe ne concordent pas";
        }

        return $errors;
    }

    public static function addToArchive(Releve $releve): bool
    {
        $pdo = DBConnection::getInstance();

        $vals = [
        $releve->getId_student(),
        $releve->getId_faculty(),
        $releve->getId_department(),
        $releve->getId_level(),
        $releve->getId_trail(),
        $releve->getPdf_name(),
        $releve->getPdf_link(),
        $releve->getObtained_at()
    ];
        
        $request = $pdo->prepare("INSERT INTO `releve`(`id_student`, `id_faculty`, `id_department`, `id_level`, `id_trail`, `pdf_name`, `pdf_link`, `obtained_at`) VALUES (?,?,?,?,?,?,?,?)");
        
        try{
            $request->execute($vals);
        }
        catch(PDOException $e){
            dump($e->getMessage());
            return false;
        }
            return true;
    }

    public function getRelevesByStudentRegist_number($regist_number) :array
    {
        $pdo = DBConnection::getInstance();

        $id = $this->getIdStudentByRegist_number($regist_number);
        try{
            $request = $pdo->query("SELECT * FROM `releve` WHERE `id_student` = '$id'");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des releves:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getRelevesByObtained_at($date) :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `releve` WHERE `obtained_date` = '$date'");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des releves:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getStudentRegist_number() :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT `id`, `regist_number` FROM `student`");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des etudiants:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getIdStudentByRegist_number($regist_number): ?int
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT `id` FROM `student` WHERE `regist_number` = '$regist_number'");
            $data = $request->fetch(PDO::FETCH_COLUMN);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des etudiants:<br>");
            echo $pe->getMessage();
            exit;
        }
        if(empty($data))
            return null;
        return $data; 
    }

    public function getStudentByRegist_number($regist_number): array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `student` WHERE `regist_number` = '$regist_number'");
            $data = $request->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des etudiants:<br>");
            echo $pe->getMessage();
            exit;
        }
        if(empty($data))
            return [];
        return $data; 
    }

    public function getFaculties() :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `faculty`");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des facultes:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getDepartments() :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `department`");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des departements:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getDepartmentById($id) :array
    {
        $pdo = DBConnection::getInstance();
        $id = (int)$id;

        try{
            $request = $pdo->query("SELECT * FROM `department` WHERE `id`='$id'");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des departements:<br>");
            echo $pe->getMessage();
            exit;
        }

        if(empty($data))
            return [];
        return $data[0];
    }

    public function getLevels() :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `level`");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des niveaux:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getLevelById($id) :array
    {
        $pdo = DBConnection::getInstance();
        $id = (int)$id;

        try{
            $request = $pdo->query("SELECT * FROM `level` WHERE `id`='$id'");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des niveaux:<br>");
            echo $pe->getMessage();
            exit;
        }

        if(empty($data))
            return [];
        return $data[0];
    }

    public function getTrails() :array
    {
        $pdo = DBConnection::getInstance();

        try{
            $request = $pdo->query("SELECT * FROM `trail`");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des filieres:<br>");
            echo $pe->getMessage();
            exit;
        }

        return $data;
    }

    public function getTrailById($id) :array
    {
        $pdo = DBConnection::getInstance();
        $id = (int)$id;

        try{
            $request = $pdo->query("SELECT * FROM `trail` WHERE `id`='$id'");
            $data = $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $pe){
            print("Une erreur s'est produite lors de la selection des parcours:<br>");
            echo $pe->getMessage();
            exit;
        }

        if(empty($data))
            return [];
        return $data[0];
    }

}