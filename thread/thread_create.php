<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\Database;
use App\ThreadLogic;
use App\Token;

// csrf 対策
Token::validate();

$title = filter_input(INPUT_POST, "title");
$comment = filter_input(INPUT_POST, "comment");


$pdo = Database::getInstance();
$threadLogic = new ThreadLogic($pdo); 

$memberLogic = new 

// $member = new 

$threadLogic->setMember();

$threadLogic->createThread($_POST);

header("Location:" . threadListPage);

?>