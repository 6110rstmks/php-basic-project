<?php

session_start();

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

    header('Location: login.php');

    // $url = 'http://cppe.hol.es/post.php';

    // $data = array(
    //     'email' => $email,
    // );

    // $context = array(
    //     'http' => array(
    //         'method'  => 'POST',
    //         'header'  => implode("\r\n", array('Content-Type: application/x-www-form-urlencoded',)),
    //         'content' => http_build_query($data)
    //     )
    // );

    // $html = file_get_contents($url, false, stream_context_create($context));

    // echo $html;

} else {
    session_regenerate_id(true);

    $_SESSION['login_user'] = $member;
    header('Location: top_blade.php');
}



