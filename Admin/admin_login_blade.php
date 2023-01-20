<?php

session_start();

require_once(__DIR__ . '/../config.php');
require_once("../function.php");


$login_id = FormValueRetention('login_id');

if (isset($_SESSION['err']))
{
    $session_msgs = $_SESSION['err'];
}

$_SESSION = array();

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
    <h2>管理画面</h2>
    <form action="<?= adminLoginCheck ?>" method="POST">
        <?php if(isset($session_msgs)): ?>
            <?php foreach($session_msgs as $msg): ?>
                <p style="color: red;"><?= $msg ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <p>
            <label for="">ログインID</label>
            <input type="text" name="login_id" value="<?php if(isset($login_id) ){ echo $login_id; } ?>">
        </p>

        <p>
            <label for="">パスワード</label>
            <input type="password" name="password" id="">
        </p>
        <button>ログイン</button>
    </form>
</body>
</html>