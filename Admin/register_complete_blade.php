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

header('Location:' . memberList);

?>
