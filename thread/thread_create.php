<?php

// session_start();
require_once("../config.php");
require_once("../App/Database.php");
require_once("../App/threadLogic.php");
require_once("../App/Token.php");
require_once("../App/ThreadLogic.php");

use App\Database;
use App\ThreadLogic;


$title = filter_input(INPUT_POST, "title");
$comment = filter_input(INPUT_POST, "comment");

if (is_null($title))
{
    exit("不正なリクエストです");
}


$pdo = Database::getInstance();
$threadLogic = new ThreadLogic($pdo); 

$threadLogic->createThread($_POST);

header("Location:" . threadListPage);

?>