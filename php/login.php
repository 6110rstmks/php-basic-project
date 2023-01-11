<?php
session_start();
$session_msgs = $_SESSION;
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
    <h2>ログイン</h2>
    <form action="./login_check.php" method="POST">
        <p>
            <span>メールアドレス</span>
            <input type="email" name="email" id="" value="<?php if(isset($session_msgs['email']) ){ echo $session_msgs['email']; } ?>">
        </p>
        <p>
            <span>パスワード</span>
            <input type="password" name="password">
        </p>

        <?php if (isset($session_msgs['match_err'])): ?>
            <p><?= $session_msgs['match_err'] ;?></p>
        <?php endif; ?>

        <button>ログイン</button>
        <button><a href="./top_blade.php">トップに戻る</a></button>

    </form>
</body>
</html>

