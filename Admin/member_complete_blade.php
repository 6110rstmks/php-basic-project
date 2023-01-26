<?php

session_start();

require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\Database;
use App\Token;

// Token::validate();

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo); 

$file = $_SESSION['file'];
unset($_SESSION['file']);

if ($file == "regist")
{
    $memberLogic->createMember($_POST);
} elseif ($file == "edit")
{
    $memberLogic->updateMember($_POST);
}

unset($_SESSION['temp_sql']);
unset($_SESSION['last_name']);
unset($_SESSION['first_name']);
unset($_SESSION['sex']);
unset($_SESSION['prefecture']);
unset($_SESSION['other_address']);
unset($_SESSION['email']);
unset($_SESSION['file']);

header('Location:' . memberList);

?>
