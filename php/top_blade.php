<?php

session_start();

// $_SESSION = array();

// ログインをしている場合、ログイン情報を格納。
// ログインをしていない場合はnull
$user_info = isset($_SESSION['login_user']) ? (array) $_SESSION['login_user'] : null;

/**
 * @var bool
 * ログインしているかを表す。
 * false: ログインしていない
 */
$login_flg = false;

// ログインしているユーザでトップ画面に入った場合
if (!is_null($user_info))
{
    $login_flg = true;
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

    <header>
        <?php if ($login_flg): ?>

            <span>ようこそ、<?= $user_info['name_sei'] . $user_info['name_mei'] ?>さん</span>

            <a><button>ログアウト</button></a>

        <?php else: ?>

            <a href="./member_regist.php"><button>新規登録</button></a>
            <a href="./login.php"><button>ログイン</button></a>

        <?php endif ; ?>

    </header>


    <section>
        <p>keiziban</p>
    </section>

    
</body>
</html>