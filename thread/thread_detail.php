<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\ThreadLogic;
use App\Database;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);
$memberLogic = new MemberLogic($pdo);

$thread_num = (int) $_GET['id'];

$thread = $threadLogic->getThreadById($thread_num);

// ログインしているメンバのID
$member_id = $_SESSION['login_member']['id'];

$memberLinkedThread = $memberLogic->getMemberById($member_id);

$auth_flg = MemberLogic::checkAuthenticated(true);

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

    <hr>

    <span>投稿者:</span>
    <span><?= $memberLinkedThread->name_sei . $memberLinkedThread->name_mei ?></>
    <span><?= $thread['created_at'] ?></span>



    <?php if ($auth_flg): ?>
        <form action="">
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </form>
    <?php endif;?>
</body>
</html>