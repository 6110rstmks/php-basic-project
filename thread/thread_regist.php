<?php

session_start();

require_once("../config.php");
require_once("../App/UserLogic.php");

use App\UserLogic;

$logic_flg = UserLogic::checkAuthenticated();

if (!$logic_flg)
{
    exit("ログインしていない場合はアクセスできません。");
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
    <h1>スレッド作成フォーム</h1>
    <form action="<?= threadRegisterConfirmPage ?>">
        <p>
            <label for="">スレッドタイトル</label>
            <input type="text" name="title">
        </p>
        <p>
            <label for="">コメント</label>
            <textarea name="comment" cols="30" rows="10"></textarea>
        </p>

        <button>確認画面へ</button>
    </form>
    <button><a href="../<?= topPage?>">トップへ戻る</a></button>
</body>
</html>