<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$email = filter_input(INPUT_POST, 'email');

$password = filter_input(INPUT_POST, 'password');

$pdo = Database::getInstance();

$memberLogic = new MemberLogic($pdo);

/**
 * 空のarrayがかえって来た場合、ログイン失敗
 * @var array
 */
$member = $memberLogic->login($email, $password); 

// 一致するIdもしくはパスワードがなければ
// if ($member === false)
if (empty($member) || !is_null($member[0]['deleted_at']))
{

    $_SESSION['match_err'] = 'IDもしくはパスワードが間違っています';
    $_SESSION['email'] = $email;

    header('Location:' . loginPage);


} else {
    session_regenerate_id(true);

    $_SESSION['login_member'] = $member;
    header('Location:../' . topPage);
}



