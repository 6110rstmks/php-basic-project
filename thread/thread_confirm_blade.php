<?php

session_start();
require_once(__DIR__ . '/../config.php');


use App\Token;


$title = filter_input(INPUT_POST, "title");

$comment = filter_input(INPUT_POST, "comment");

if (!isset($title))
{
    exit('不正なリクエストです。');
}

$err_flg = false;

// ---title---
$len = mb_strlen($title, "UTF-8");

$wdt = mb_strwidth($title, "UTF-8");


if($len == $wdt) {
    // すべて半角の場合

    if (strlen($title) >= 101)
    {
        $mozisuu = strlen($title);
        $_SESSION['thread_title_count'] = 'タイトルの入力は100文字以下である必要があります';
        $err_flg = true;
    }

} 
elseif($len * 2 == $wdt) {
// すべて全角の場合
    if (mb_strlen($title) > 100)
    {
        $zenkakumozisuu = mb_strlen($title);
        $_SESSION['thread_title_count'] = 'タイトルの入力は100文字以下である必要があります';
        $err_flg = true;
    }

} else {
// 全角・半角が混在している場合

}


if (empty($title))
{
    $_SESSION['thread_title_required'] = 'タイトルは必須入力です。';
    $err_flg = true;

}

// ---comment----

$len = mb_strlen($comment, "UTF-8");
$wdt = mb_strwidth($comment, "UTF-8");

if($len == $wdt) {
    // すべて半角の場合

    if (strlen($comment) >= 501)
    {
        $_SESSION['thread_comment_count'] = 'コメントの入力は500文字以下である必要があります';
        $err_flg = true;
    }

} elseif($len * 2 == $wdt) {
// すべて全角の場合
    if (mb_strlen($comment) >= 501)
    {
        $zenkakuzz = mb_strlen($comment);
        $_SESSION['thread_comment_count'] = 'コメントの入力は500文字以下である必要があります';
        $err_flg = true;
    }

} else {
// 全角・半角が混在している場合

}


if (empty($comment))
{
    $_SESSION['thread_comment_required'] = 'コメントは必須入力です。';
    $err_flg = true;
}


// -------------------

if ($err_flg)
{
    $_SESSION['thread_title'] = $title;
    $_SESSION['thread_comment'] = $comment;

    header('Location: '. threadRegisterFormPage);
    exit();
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
    <h2>スレッド作成確認画面</h2>
    <div>スレッドタイトル</div>
    <span style="display: inline"><?= $title?></span>

    <div>コメント</div>
    <span><?= nl2br($comment) ?></span>

    <form action="<?= threadCreate ?>" method="POST">
        <button>スレッドを作成する</button>
        <input type="hidden" name="title" value="<?= $title ?>">
        <input type="hidden" name="comment" value="<?= $comment ?>">
        <input type="hidden" name="csrf_token" value="<?= Token::create(); ?>">
    </form>
    <button type="button" onclick="history.back()">戻る</button>
</body>
</html>