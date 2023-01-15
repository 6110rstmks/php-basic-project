<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\ThreadLogic;
use App\Database;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);
$memberLogic = new MemberLogic($pdo);

/**
 * 
 * @var int
 */
$thread_num = (int) $_GET['id'];

$thread = $threadLogic->getThreadById($thread_num);

if (!$thread)
{
    exit('スレッドが存在しない');
}

// ログインしているメンバのID
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member']['id'];
}

// スレッドに紐づいたメンバの情報を取得
$memberLinkedThread = $memberLogic->getMemberById($thread['member_id']);


/**
 * ログインしているかどうか
 * @var bool
 */
$auth_flg = MemberLogic::checkAuthenticated(true);

/**
 * 前ページがあるかどうか
 * @var bool
 */
$prevThreadFlag = $threadLogic->prevThreadCheck($thread_num);
$nextThreadFlag = $threadLogic->nextThreadCheck($thread_num);


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
    <a href="<?= threadListPage ?>"><button>スレッド一覧に戻る</button></a>

    <h2><?= $thread['title'] ?></h2>  
    <?= $thread['created_at'] ?>

    <div style="height: 20px; width: auto; background-color: gray;">
        <?php 
            if ($prevThreadFlag)
            {
                echo '<a style="color: #0066CC;" href="thread_detail.php?id=' . $thread_num - 1 . '">前へ</a>';
            } else {
                echo '<a style="color: #707070l;">前へ</a>';
            }

            if ($nextThreadFlag)
            {
                echo '<a style="margin-left: 260px; color: #0066CC;" href="thread_detail.php?id=' . $thread_num + 1 . '">次へ</a>';
            } else {
                echo '<a style="margin-left: 260px; background-color: #707070l;">次へ</a>';
            }

        ?>
    </div>

    <span>投稿者:</span>
    <?php if (isset($memberLinkedThread)): ?>
        <span><?= $memberLinkedThread->name_sei . $memberLinkedThread->name_mei ?></>
    <?php endif; ?>
    <span><?= $thread['created_at'] ?></span>



    <?php if ($auth_flg): ?>
        <form action="">
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </form>
    <?php endif;?>
</body>
</html>