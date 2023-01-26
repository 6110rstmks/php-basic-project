<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

$id = $_GET['id'];

$member = $memberLogic->getMemberById($id);

$last_name = $member['name_sei'];
$first_name = $member['name_mei'];
$gender = $member['gender'];
$pref_name = $member['pref_name'];
$address = $member['address'];
$email = $member['email'];

if ($gender == 0)
{
    $gender = '男性';
} else {
    $gender = '女性';
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
    <section style="display: flex; justify-content: space-between;">
        <h2>会員詳細</h2>
        <button type="button" onclick="history.back()">一覧に戻る</button>
    </section>
    <div>
        <span>ID</span>
        <span><?= $id ?></span>
    </div>
    
    <div style="display: flex;">
        <div>氏名</div>
        <span style="display: inline"><?= $last_name?></span>
        <span style="display: inline"><?php echo $first_name; ?></span>
    </div>

    <div style="display: flex;">

        <div>性別</div>
        <div><?= $gender ?></div>
    </div>

    <div style="display: flex;">
        <div>住所</div>
        <div><?= $pref_name . $address ?></div>
    </div>

    <div style="display: flex;">
        <div>パスワード</div>
        <div>セキュリティのため非表示</div>
    </div>

    <div style="display: flex;">
        <div>メールアドレス</div>
        <div><?= $email ?></div>
    </div>

    <button><a href="<?= memberEditPage . '?id=' . $id ?>">編集</a></button>
    <button><a href="<?= memberDeletePage . '?id=' . $id ?>">削除</button>
</body>
</html>