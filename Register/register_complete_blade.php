<?php

session_start();

require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\Database;
use App\Token;

Token::validate();

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo); 

$memberLogic->createMember($_POST);

unset($_SESSION['last_name']);
unset($_SESSION['first_name']);
unset($_SESSION['sex']);
unset($_SESSION['prefecture']);
unset($_SESSION['other_address']);
unset($_SESSION['email']);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>会員登録完了</h1>
<h2>会員登録が完了しました。</h2>
</body>
</html>
