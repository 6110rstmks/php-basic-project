<?php

session_start();

require_once(__DIR__ . '/../config.php');
require_once("../function.php");


use App\MemberLogic;

// ログインしていなければcheckAuthenticated method内において
// exitで処理を中断させる。
// ログインユーザ専用ページのためfalseを指定
$logic_flg = MemberLogic::checkAuthenticated(false);

// 
$thread_title = FormValueRetention('thread_title');
$thread_comment = FormValueRetention('thread_comment');

// ②の中で$_SESSION = array();の処理をするために
// 変数を退避
if (isset($_SESSION['login_member']))
{
    $login_member = (array) $_SESSION['login_member'];
    unset($_SESSION['login_member']);
}


// バリデーションを満たさず、
// ログイン画面に戻ってきたときに、値を保持する
if (isset($_SESSION['title'])
    && isset($_SESSION['comment']))
{
    $title = $_SESSION['title'];
    $comment = nl2br($_SESSION['comment']);

    unset($_SESSION['title']);
    unset($_SESSION['comment']);
}


// ②エラーメッセージをセッション変数から変数へ格納
// セッション変数内のエラーメッセージを削除
if (isset($_SESSION['thread_title_required'])
    || isset($_SESSION['thread_title_count'])
    || isset($_SESSION['thread_comment_required'])
    || isset($_SESSION['thread_comment_count']))
{
    $session_err_msgs = (array) $_SESSION;
    $_SESSION = array();
}



// 退避した変数を再び格納
$_SESSION['login_member'] = $login_member;

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
    <?php

        if (isset($session_err_msgs))
        {
            var_dump($session_err_msgs);
        }
    ?>
    <h1>スレッド作成フォーム</h1>
    <form action="<?= threadRegisterConfirmPage ?>" method="POST">
        <?php if (isset($session_err_msgs)): ?>
            <?php foreach($session_err_msgs as $msg): ?>
                <span><?= $msg; ?></span>
            <?php endforeach;?>
        <?php endif;?>

        <p>
            <label for="">スレッドタイトル</label>
            <input type="text" name="title" value="<?php if(isset($thread_title) ){ echo $thread_title; } ?>">
        </p>
        <p>
            <label for="">コメント</label>
            <textarea name="comment" cols="30" rows="10"><?php if(isset($thread_comment)) { echo $thread_comment; } ?></textarea>
        </p>

        <button>確認画面へ</button>
    </form>
    <button><a href="../<?= topPage?>">トップへ戻る</a></button>
    <button><a href="<?= threadDetail ?>">スレッド一覧にもどる</a></button>
</body>
</html>