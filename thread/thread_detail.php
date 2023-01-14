<?php

require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\ThreadLogic;
use App\Database;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);

$thread_num = (int) $_GET['id'];

$thread = $threadLogic->getThreadById($thread_num);


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
    <h2><?= $thread['title'] ?></h2>  
    <?= $thread['created_at'] ?>
</body>
</html>