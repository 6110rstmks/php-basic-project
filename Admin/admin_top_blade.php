<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\adminLogic;

// ログインしていなければcheckAuthenticated method内において
// exitで処理を中断させる。
// ログインユーザ専用ページのためfalseを指定
$logic_flg = adminLogic::checkAuthenticated();

$admin_name = $_SESSION['login_admin'][0]['name'];

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
    <div style="display: flex; gap: 19px">
        <div>掲示板管理画面メインメニュー</div>
    
        <div>ようこそ<?= $admin_name ?></div>
        <form action="<?= adminLogout ?>" method="POST">
            <button>ログアウト</button>
            <input type="hidden" name="logout" value="logout">
        </form>
    </div>
</body>
</html>