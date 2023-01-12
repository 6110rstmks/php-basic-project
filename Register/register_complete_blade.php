<?php

require_once("../config.php");
require_once("../App/Database.php");
require_once("../App/UserLogic.php");

use App\UserLogic;
use App\Database;

$pdo = Database::getInstance();
$userLogic = new UserLogic($pdo); 

$userLogic->createUser($_POST);


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
