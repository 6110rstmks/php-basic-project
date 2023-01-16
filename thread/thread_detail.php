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
 * 前、次のコメントのページャー（5つ）のグループがあるかどうか
 * @var bool
 */

// $prevCommentFlg = $commentLogic->prevCommentCheck($)

/**
 * 総コメント数を取得
 * @var int
 */
$comment_ttl = $commentLogic->getCommentCountLinkedWithThread($thread_num);

// コメントのページャーの数
$comment_pager_ttl = ($comment_ttl % 5) + 1;

  
/**
 * 
 */
if (isset($_POST['comment_pager']))
{
    $now_comment_pager = (int) $_POST['comment_pager'];
} else {
    $now_comment_pager = 1;
}

$prev_comment_pager = $now_comment_pager == 1 ? null : max($now_comment_pager - 1, 1); 
$next_comment_pager = $now_comment_pager == $comment_pager_ttl ? null : min($now_comment_pager + 1, $comment_ttl); 

$offset = ($now_comment_pager - 1) * 5;


/**
 * 現在のスレッドページのidをレコードにもつに関連するコメントをoffsetの数分（かずぶん）、しゅとく
 * @var array
 */
$comments = $commentLogic->getCommentsLinkedWithThread($thread_num, $offset);

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
        <?php if ($prevThreadFlag): ?>
            <a style="color: #0066CC;" href="thread_detail.php?id=' . $thread_num - 1 . '">前へ</a>
        <?php else: ?>   
            <a style="color: #707070l;">前へ</a>
        <?php endif; ?>

        <?php if ($prevThreadFlag): ?>
            <a style="margin-left: 260px; color: #0066CC;" href="thread_detail.php?id=' . $thread_num + 1 . '">次へ</a>
        <?php else: ?>   
            <a style="margin-left: 260px; background-color: #707070l;">次へ</a>
        <?php endif; ?>
    </div>

    <div style="margin-top: 20px; border: 1px blue solid; color: blue;">
        <div>
            <span>投稿者:</span>
            <?php if (isset($memberLinkedThread)): ?>
                <span><?= $memberLinkedThread->name_sei . $memberLinkedThread->name_mei ?></>
            <?php endif; ?>
            <span><?= $thread['created_at'] ?></span>
        </div>
    
        <div><?= $thread['content']?></div>
    </div>

    <div>
        <!-- コメント表示部分 -->
        <?php if (isset($comments)):?>
            <?php foreach($comments as $comment): ?>
                <div>
                    <span><?= $comment['id'] ?></span>
                    <span><?= $comment['comment'] ?></span>
                    <hr>
                </div>
    
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- コメントのページャー -->
    <div style="height: 20px; width: auto; background-color: gray;">
        <!-- ＜前へ＞ -->
        <form action="" style="display: inline;" class="comment-pager-form1" method="POST">
            <?php if (is_null($prev_comment_pager)): ?>
                <span>前へ</span>
            <?php else:?>
                <a class="prev-button" style="cursor: pointer">前へ</a>
            <?php endif;?>

            <input type="hidden" name="comment_pager" value="<?= $prev_comment_pager ?>">
        </form>

        <!-- ＜後へ＞ -->
        <form action="" style="display: inline; margin-left: 50px;" class="comment-pager-form2" method="POST">
            <?php if (is_null($next_comment_pager)): ?>
                <span>次へ</span>
            <?php else:?>
                <a class="prev-button" style="cursor: pointer">次へ</a>
            <?php endif;?>

            <input type="hidden" name="comment_pager" value="<?= $next_comment_pager ?>">
        </form>
    </div>

    <!-- コメントボックス -->
    <?php if ($auth_flg): ?>
        <form action="<?= dir5 . commentSave ?>" method="POST">

            <textarea name="comment" id="" cols="30" rows="10"></textarea>
            <input type="hidden" name="thread_id" value="<?= $thread_num?>">
            <button>コメントする</button>
        </form>
    <?php endif;?>

    <script>
        // ページャー用のjs
        const comment_pager_form = document.querySelector('.comment-pager-form')
        const prev_button = document.querySelector('.prev-button')
        const next_button = document.querySelector('.next-button')

        prev_button.addEventListener('click', () => {
            prev_button.parentElement.submit();
        })

        next_button.addEventListener('click', () => {
            next_button.parentElement.submit();
        })
    </script>
</body>
</html>