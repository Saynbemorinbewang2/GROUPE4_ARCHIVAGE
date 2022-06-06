<?php
    session_start();
    
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'UserManager.class.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'User.class.php';
    $admin = UserManager::getInstance();

    $users = $admin->getUsers();
    if(!empty($users)){
        header('Location:login_user.php');
        exit;
    }

    $errors = [];
    if(!empty($_POST['pseudo'])){
        $user = new User();
        $user->hydrate(['name'=>$_POST['pseudo'], 'password1'=>$_POST['password1'], 'password2'=>$_POST['password2']]);
        if($user->isValidUser()){
            $admin->addUser($user);
            $_SESSION['connected'] = true;
            $_SESSION['admin'] = $user->getName();
            header('Location:../index.php');
            exit;
        }
        else{
            $errors = $user->getErrors();
        }
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Style/style_form.css">
</head>
<body>
<div class="container-form">
    <div class="form">
        <h1>Nouvel administrateur</h1>

        <?php if(!empty($errors)){
            echo '<div class="box-errors">';
            foreach($errors as $error){
                echo $error . '<br>';
            }    
            echo '</div>';
        } ?>

        <form action="" method="post">
            <label for="idPseudo">Pseudo</label><br>
            <input type="text" name="pseudo" id="idPseudo" placeholder="votre nom" required><br>
            <label for="idPassword">Mot de passe</label><br>
            <input type="password" name="password1" id="idPassword" placeholder="mot de pass" required><br>
            <label for="idPassword">confirmer</label><br>
            <input type="password" name="password2" id="idPassword" placeholder="confirmer le pass" required><br>
            <button class="btn-primary">Envoyer</button>
        </form>
    </div>
</div>