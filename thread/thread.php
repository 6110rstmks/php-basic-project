<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\MemberLogic;
use App\ThreadLogic;
use App\Database;

$pdo = Database::getInstance();

$threadLogic = new ThreadLogic($pdo);

//　ログインしているかどうか
$auth_flg = MemberLogic::checkAuthenticated(true);

// ワードからスレッドを取得する
if (isset($_POST['word']))
{
    $word = $_POST['word'];


    /**
     * 検索したワードがタイトルもしくはコメント内にあるスレッド一覧を取得
     * @var array|null
     */
    $threads = $threadLogic->searchThread($word);

    
} else {
    $threads = $threadLogic->getAllThreads();
}



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
    <?php if ($auth_flg): ?>
        <a href="<?= threadRegisterFormPage ?>"><button>新規作成</button></a>
    <?php endif;?>
    <form method="POST">
        <input type="text" name="word" id="">
        <button>スレッド検索</button>
    </form>

    <?php if (isset($threads)): ?>
        <?php foreach($threads as $thread): ?>
            <?php
                $thread_year = substr($thread['created_at'], 0, 4);
                $thread_month = substr($thread['created_at'], 5, 2);
                $thread_day = substr($thread['created_at'], 8, 2);
                $thread_hour = substr($thread['created_at'], 11, 2);
                $thread_minute = substr($thread['created_at'], 14, 2);

                $thread_time = $thread_year . '.' . $thread_month . '.' . $thread_day . '.' . $thread_hour . ':' . $thread_minute;

            ?>
            <div>
                <span>ID:</span><?= $thread['id']?>
                <a href="thread_detail.php?id=<?= $thread['id'] ?>"><?= $thread['title'] ?></a>
                <span><?= $thread_time ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif;?>

    <button><a href="../<?= topPage ?>">トップに戻る</a></button>
</body>
</html>

