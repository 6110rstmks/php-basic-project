<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\MemberLogic;
use App\ThreadLogic;
use App\Database;
use App\CommentLogic;
use App\LikeLogic;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);
$memberLogic = new MemberLogic($pdo);
$commentLogic = new CommentLogic($pdo);
$likeLogic = new LikeLogic($pdo);

/**
 * GETリクエストでのスレッド番号
 * @var int
 */
$thread_num = (int) $_GET['id'];


if (!$thread_num)
{
    exit('スレッドが存在しない');
}

/**
 * スレッドidに紐づくスレッドの情報を取得
 * @var array|
 */
$thread = $threadLogic->getThreadById($thread_num);

// スレッドidが存在しないidでアクセスしたとき
if ($thread === false)
{
    echo '<a>スレッド一覧へ</a>';
    echo '<br>';
    exit('そのidを持つスレッドが作られていません');
}

// ログインしているメンバのIDを取得
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member'][0]['id'];
    // $member_id = $_SESSION['login_member']->id;
}

// コメントのフォームが空だった場合に受け取ったエラーメッセージを
// 変数に格納
if (isset($_SESSION['err']))
{
    $errs = $_SESSION['err'];
    unset($_SESSION['err']);
}

// 
/**
 * スレッドに紐づいたメンバの情報を取得
 * @var array|bool
 */
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
 * あるスレッド一つに紐づく総コメント数を取得
 * @var int
 */
$comment_ttl = $commentLogic->getCommentCountLinkedWithThread($thread_num);


/**
 * コメントのページャーの数を算出
 * @var int
 */
$comment_pager_ttl = ($comment_ttl % 5) + 1;

  
/**
 * $now_comment_pager @var int
 * コメントにおける現在のページャーを表す。
 */
if (isset($_POST['comment_pager']))
{
    $now_comment_pager = (int) $_POST['comment_pager'];
} else {
    $now_comment_pager = 1;
}

// ＜前へ＞のリンクにいれるためのページナンバー
$prev_comment_pager = $now_comment_pager === 1 ? null : max($now_comment_pager - 1, 1); 
$next_comment_pager = $now_comment_pager === $comment_pager_ttl || $comment_pager_ttl == 1 ? null : min($now_comment_pager + 1, $comment_ttl); 

$offset = ($now_comment_pager - 1) * 5;

/**
 * 現在のスレッドページのidをレコードにもつに関連するコメントをoffsetの数分（かずぶん）、しゅとく
 * @var array
 */
$comments = $commentLogic->getCommentsLinkedWithThread($thread_num, $offset);


// スレッド投稿時間作成のための変数を用意
$month = substr($thread['created_at'], 5, 2);
$day = substr($thread['created_at'], 8, 2);
$year = substr($thread['created_at'], 2, 2);
$hour = substr($thread['created_at'], 11, 2);
$minute = substr($thread['created_at'], 14, 2);

$thread_detail_time = $month . '/' . $day . '/' . $year . ' ' . $hour . ':' . $minute;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <title>Document</title>
</head>
<body style="background-color: #B0E0E6">
    <a href="<?= threadListPage ?>"><button>スレッド一覧に戻る</button></a>

    <h2><?= $thread['title'] ?></h2>  
    <span><?= $comment_ttl ?>コメント</span>
    <span><?= $thread_detail_time ?></span>


    <!-- 前のスレッドへ、次のスレッドへの部分 -->
    <div style="height: 20px; width: auto; background-color: gray;">
        <?php if ($prevThreadFlag): ?>
            <a style="color: #0066CC;" href="thread_detail.php?id=<?= $thread_num - 1?>">前へ</a>
        <?php else: ?>   
            <a style="color: #707070l;">前へ</a>
        <?php endif; ?>

        <?php if ($nextThreadFlag): ?>
            <a style="margin-left: 260px; color: #0066CC;" href="thread_detail.php?id=<?= $thread_num + 1 ?>">次へ</a>
        <?php else: ?>   
            <a style="margin-left: 260px; background-color: #707070l;">次へ</a>
        <?php endif; ?>
    </div>

    <!-- スレッドの投稿者、投稿日時、内容 -->
    <div style="margin-top: 20px; border: 1px blue solid; color: blue;">
        <div>
            <span>投稿者:</span>
            <?php if ($memberLinkedThread != false): ?>
                <span><?= $memberLinkedThread->name_sei . $memberLinkedThread->name_mei ?></>
            <?php endif; ?>
            <?php
                $thread_year = substr($thread['created_at'], 0, 4);
                $thread_month = substr($thread['created_at'], 5, 2);
                $thread_day = substr($thread['created_at'], 8, 2);
                $thread_hour = substr($thread['created_at'], 11, 2);
                $thread_minute = substr($thread['created_at'], 14, 2);

                $thread_time = $thread_year . '.' . $thread_month . '.' . $thread_day . '       ' . $thread_hour . ':' . $thread_minute;
            ?>
            <?= $thread_time ?>
        </div>
    
        <div><?= $thread['content']?></div>
    </div>

    <div>
        <!-- コメント表示部分 -->
        <?php if (isset($comments)):?>
            <?php foreach($comments as $comment): ?>

                <?php

                    // $commentをしたmemberの情報を取得
                    /**
                     * 
                     */
                    $member = $commentLogic->getMemberLinkedWithComment($comment['member_id']);

                    $member_name = $member['name_sei'] . $member['name_mei'];

                    $comment_year = substr($comment['created_at'], 0, 4);
                    $comment_month = substr($comment['created_at'], 5, 2);
                    $comment_day = substr($comment['created_at'], 8, 2);
                    $comment_hour = substr($comment['created_at'], 11, 2);
                    $comment_minute = substr($comment['created_at'], 14, 2);

                    $comment_time = $comment_year . '.' . $comment_month . '.' . $comment_day . '.' . $comment_hour . ':' . $comment_minute;
                ?>
                <div>
                    <span><?= $comment['id'] ?>.</span>
                    <span><?= $member_name ?></span>
                    <span><?= $comment_time ?></span>
                    <div>
                        <span><?= $comment['comment'] ?></span>
                    </div>
                    <div>
                        <?php
                            // ----いいねに関するロジック

                            /**
                             * コメントに紐づくlikeの個数を取得
                             * @var int
                             */
                            $like_count = $likeLogic->getLikeCountLinkedWithComment($comment['id']);

                        ?>
                        <!-- ハート -->
                        <!-- ログインしている場合、likeToggleへ繊維 -->
                        <?php if ($auth_flg): ?>
                            <form method="POST" action="<?= dir6 . likeToggle ?>">
                                <?php if ($like_count === 0): ?>
                                    <i class="like fa fa-heart"></i>

                                <?php else: ?>
                                    <i class="like liked fa fa-heart"></i>
                                <?php endif;?>
                            <input type="hidden" name="thread_id" value="<?= $thread_num?>">
                            <input type="hidden" name="comment_id" value="<?= $comment['id']?>">
                            </form>
                        <!-- ログインしていない場合、loginPageへ遷移 -->
                        <?php else: ?>
                            <form method="GET" action="../<?= dir2 . memberRegisterFormPage ?>">
                                <?php if ($like_count === 0): ?>
                                    <i class="like fa fa-heart"></i>
                                <?php else: ?>
                                    <i class="like liked fa fa-heart"></i>
                                <?php endif;?>
                            </form>
                        <?php endif;?>
                        <span><?= $like_count ?></span>
                    </div>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- コメントのページャー -->
    <div style="height: 20px; width: auto; background-color: #BEBEBE;">
        <!-- ＜前へ＞ -->
        <form action="" style="display: inline;" class="comment-pager-form1" method="POST">
            <?php if (is_null($prev_comment_pager)): ?>
                <span style="font-size: 13.8px">前へ</span>
            <?php else:?>
                <a class="prev-button" style="cursor: pointer">前へ</a>
            <?php endif;?>

            <input type="hidden" name="comment_pager" value="<?= $prev_comment_pager ?>">
        </form>

        <!-- ＜後へ＞ -->
        <form action="" style="display: inline; margin-left: 50px;" class="comment-pager-form2" method="POST">
            <!-- 次のコメントのページャーがあるかどうか -->
            <?php if (is_null($next_comment_pager)): ?>
                <span style="font-size: 12px">次へ</span>
            <?php else:?>
                <a class="prev-button" style="cursor: pointer; font-size: 15px">次へ</a>
            <?php endif;?>

            <input type="hidden" name="comment_pager" value="<?= $next_comment_pager ?>">
        </form>
    </div>

    <!-- コメント追加ボックス -->
    <?php if ($auth_flg): ?>
        <form action="<?= dir5 . commentSave ?>" method="POST">

            <textarea name="comment" id="" cols="30" rows="10"></textarea>
            <input type="hidden" name="thread_id" value="<?= $thread_num?>">
            <button>コメントする</button>
        </form>

        <?php if (isset($errs)): ?>
            <?php foreach($errs as $err): ?>
                <span style="color: red"><?= $err ?></p>
            <?php endforeach;?>
        <?php endif;?>
    <?php endif;?>

    <script>
        // いいねクリック処理
        const likes = document.querySelectorAll('.like');

        likes.forEach(like => {

            addEventListener('click', e => {
                // いいねをクリックしたらフォームを送信
                e.target.parentElement.submit()
            })
        })


        // const 

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