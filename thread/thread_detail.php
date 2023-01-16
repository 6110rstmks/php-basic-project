<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\ThreadLogic;
use App\Database;
use App\CommentLogic;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);
$memberLogic = new MemberLogic($pdo);
$commentLogic = new CommentLogic($pdo);

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

// ログインしているメンバのIDを取得
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member']['id'];
    // $member_id = $_SESSION['login_member']->id;
}

// スレッドに紐づいたメンバの情報を取得
$memberLinkedThread = $memberLogic->getMemberById($thread['member_id']);


/**
 * ログインしているかどうか
 * @var bool
 */
$auth_flg = MemberLogic::checkAuthenticated(true);

/**
 * スレッドの前、次ページがあるかどうか
 * @var bool
 */
$prevThreadFlag = $threadLogic->prevThreadCheck($thread_num);
$nextThreadFlag = $threadLogic->nextThreadCheck($thread_num);

/**
 * コメントの前、次ページがあるかどうか
 * @var bool
 */

//  $prevCommentFlg = $commentLogic->prevCommentCheck($)

/**
 * 総コメント数を取得
 * @var int
 */
$comment_ttl = $commentLogic->getCommentCountLinkedWithThread($thread_num);


/**
 * １ページャーに表示される、一番上のコメントのidからマイナス１した値
 */
// if (!isset($_SESSION['comment_offset']))
// {
//     $offset = 1;
//     $comment_pager = 1;

// } else {

//     $offset = $_SESSION['comment_offset'];
// }

// $offset = ($offset - 1) * 3;

// $_SESSION['comment_offset'] = $offset;
  
if (isset($POST['comment_pager']))
{
    $comment_pager = $_POST['comment_pager'];
} else {
    $comment_pager = 1;
}

$offset = ($comment_pager - 1) * 3;


/**
 * 現在のスレッドページのidをレコードにもつに関連するコメントをoffset分取得取得
 * @var array
 */
$comments = $commentLogic->getCommentsLinkedWithThread($thread_num, $offset);
// $comments = $commentLogic->getCommentsLinkedWithThread($thread_num);

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
    <p><?= $comment_ttl ?>コメント</p>
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

    <!-- コメント表示部分 -->
    <?php if (isset($comments)):?>
        <?php foreach($comments as $comment): ?>
            <p><?= $comment['comment'] ?></p>
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if ($auth_flg): ?>
        <form action="<?= dir5 . commentSave ?>" method="POST">

            <textarea name="comment" id="" cols="30" rows="10"></textarea>
            <input type="hidden" name="thread_id" value="<?= $thread_num?>">
            <input type="hidden" name="">
            <button>コメントする</button>
        </form>
    <?php endif;?>



    <div style="height: 20px; width: auto; background-color: gray;">
        <form action="" class="my_form" method="POST">
            <a href="" onclick="document.getElementById('my_form').submit();">次へ</a>
            <input type="hidden" name="comment_pager" value="<?= $comment_pager ?>">
        </form>
    </div>
</body>
</html>