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

// ログインしているメンバのID
$member_id = $_SESSION['login_member']['id'];


$threadLogic->createThread($_POST, $member_id);

header("Location:" . threadListPage);

?>