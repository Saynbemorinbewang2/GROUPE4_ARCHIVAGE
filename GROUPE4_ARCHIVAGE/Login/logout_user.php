<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'user_function.php';
if(is_connected_user()){
    $_SESSION['connected'] = false;
    $_SESSION['admin'] = null;
}
header('Location:login_user.php');
exit;

?>