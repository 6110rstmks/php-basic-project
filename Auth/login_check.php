<?php

session_start();

require_once("../config.php");
require_once("../App/UserLogic.php");
require_once("../App/Database.php");

use App\Database;
use App\UserLogic;

$email = filter_input(INPUT_POST, 'email');

$password = filter_input(INPUT_POST, 'password');

$pdo = Database::getInstance();

$userLogic = new UserLogic($pdo);

$member = $userLogic->login($email, $password); 

// 一致するIdもしくはパスワードがなければ
if ($member == false)
{

    $_SESSION['match_err'] = 'IDもしくはパスワードが間違っています';
    $_SESSION['email'] = $email;

    header('Location:' . loginPage);


} else {
    session_regenerate_id(true);

    $_SESSION['login_user'] = $member;
    header('Location:../' . topPage);
}



