<?php

function is_connected_user(): bool
{
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['connected'])){
        return false;
    }
    if(empty($_SESSION['connected'])){
        return false;
    }
    if($_SESSION['connected'] == true){
        return true;
        exit;
    }
    else{
        return false;
    }
}

function force_user_connection(){
    if(!is_connected_user()){
        header('Location:Login/login_user.php');
        exit;
    }
}

function is_user($users, $user): bool{
    
    foreach($users as $data){
        if(($data['pseudo'] === $user->getName()) && password_verify($user->getPassword1(), $data['password'])){
            return true;
        }
    }
    return false;
}