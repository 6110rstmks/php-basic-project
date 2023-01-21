<?php
session_start();
require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

$login_flg = MemberLogic::checkAuthenticated(false);

if (!$login_flg)
{
    exit('ログインする必要があります。');
}

$member_id = $_SESSION['login_member'][0]['id'];

// 退会処理
if (isset($_POST['withdrawal']))
{
    $memberLogic->softDelete($member_id);
    unset($_SESSION['login_member']);
    header('Location:' . '../' . topPage);
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
    <h2>退会</h2>
    <a href="../<?= topPage ?>">トップに戻る</a>
    <p>退会しますか？</p>

    <form method="POST">
        <button>退会する</button>
        <input type="hidden" name="withdrawal" value="withdrawal">
    </form>
</body>
</html>