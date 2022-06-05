
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="Style/style.css">
    <link rel="stylesheet" href="Style/style_form.css">
    <?php 
        require "init.php";
        require MAIN. "functions" . DIRECTORY_SEPARATOR . "user_function.php"; 
        require MAIN. "functions" . DIRECTORY_SEPARATOR . "functions.php"; 
        force_user_connection();
?>
</head>
<body>
       

    <header>
        <div class="entete">
            <h1 id="appName">Archivage des relevés de notes</h1>
            <h1 id="appFaculty">Faculté des Sciences Université de Ngaoundéré</h1>
            <div class="trait trait1">...</div>
            <div class="trait trait2">...</div>
        </div>
        <nav>
            <ul>
                <li><a href="<?='./index.php'?>">Acceuil</a></li>
                <li><a href="<?='./index.php?archives=1'?>">Archives</a></li>

                <?php if(is_connected_user()){
                    ?>
                    <li class="connection-li"><a href="<?='./Login/logout_user.php'?>">Se deconnecter</a></li>
                    <?php
                }else{
                    ?>
                    <li class="connection-li"><a href="<?=LOGIN_PATH . './Login/login_user.php'?>">Se connecter</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>