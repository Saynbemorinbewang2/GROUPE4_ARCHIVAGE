<?php
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'user_function.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'functions.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'UserManager.class.php';
    require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Libs' . DIRECTORY_SEPARATOR . 'User.class.php';

    $admin = UserManager::getInstance();
    $users = $admin->getUsers();

    if(empty($users)){
        header('Location:add_user.php');
        exit;
    }
    if(is_connected_user()){
        header('Location:/index.php');
        exit;
    }
    
    $errors = [];
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])){
        
        
        $user = new User();
        $user->hydrate(['name'=>$_POST['pseudo'], 'password1'=>$_POST['password'], 'password2'=>$_POST['password']]);

        if(is_user($users, $user)){
            $_SESSION['connected'] = true;
            $_SESSION['admin'] = $user->getName();
            header('Location:../index.php');
            exit;
        }
        $_SESSION['connected'] = false;
        $errors[] = "Identifiants inccorect";
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
    <h1>Se connecter</h1>
    <?php if(!empty($errors)){
        echo '<div class="box-errors">';
        foreach($errors as $error){
            echo $error;
        }    
        echo '</div>';
    } ?>
    <div class="form">
        <form action="" method="post">
            <label for="idPseudo">Pseudo</label><br>
            <input type="text" name="pseudo" id="idPseudo" required><br>
            <label for="idPassword">Mot de passe</label><br>
            <input type="password" name="password" id="idPassword" required><br>
            <button class="btn-primary">Envoyer</button>
        </form>
    </div>
</div>
</body>
</html>