<?php

session_start();
require_once("../config.php");
require_once("../App/Database.php");
require_once("../App/UserLogic.php");
require_once("../App/Token.php");

$title = filter_input(INPUT_POST, "title");

$comment = filter_input(INPUT_POST, "content");

// ---title---

if (strlen($title) >= 101) {
    // 確認画面にリダイレクトする
    $err['thread_title_count'] = 'タイトルの入力は100文字以下である必要があります';
    // exit;
}

if (!isset($title))
{
    $err['thread_title_required'] = 'タイトルは必須入力です。';
}

// ---comment----

if (strlen($comment) >= 501) {
    // 確認画面にリダイレクトする
    $err['thread_comment_count'] = 'コメントの入力は５00文字以下である必要があります';
    // exit;
}


if (!isset($comment))
{
    $err['thread_comment_required'] = 'コメントは必須入力です。';
}


// -------------------

if (count($err) > 0)
{
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
    <span><?= $comment ?></span>

    <form action="<?= threadRegisterCompletePage ?>" method="POST">

        <input type="hidden" name="last_name" value="<?= $last_name ?>">
        <input type="hidden" name="first_name" value="<?= $first_name ?>">
        <input type="hidden" name="sex" value="<?= $sex ?>">
        <input type="hidden" name="prefecture" value="<?= $prefecture ?>">
        <input type="hidden" name="password" value="<?= $password ?>">
        <input type="hidden" name="email" value="<?= $email ?>">
        <button>完了画面</button>
    </form>
    <button type="button" onclick="history.back()">戻る</button>
</body>
</html>