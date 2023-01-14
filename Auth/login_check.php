<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$email = filter_input(INPUT_POST, 'email');

$password = filter_input(INPUT_POST, 'password');

$pdo = Database::getInstance();

$memberLogic = new MemberLogic($pdo);

$member = $memberLogic->login($email, $password); 

// 一致するIdもしくはパスワードがなければ
if ($member == false)
{

    $_SESSION['match_err'] = 'IDもしくはパスワードが間違っています';
    $_SESSION['email'] = $email;

    header('Location:' . loginPage);


} else {
    session_regenerate_id(true);

    $_SESSION['login_member'] = $member;
    header('Location:../' . topPage);
}



