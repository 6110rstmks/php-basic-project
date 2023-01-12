<?php

session_start();

require_once("./config.php");
require_once("./App/UserLogic.php");

use App\UserLogic;


// ログインをしている場合、ログイン情報を格納。
// ログインをしていない場合はnull
$user_info = isset($_SESSION['login_user']) ? (array) $_SESSION['login_user'] : null;

// ログインユーザ、ゲスト共用ページのため、trueを指定
$login_flg = UserLogic::checkAuthenticated(true);

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

            <button><a href="<?= dir4 . threadRegisterFormPage?>">新規スレッド作成</a></button>

            <!-- <form action="./logout.php" method="POST"> -->
            <form action="<?= dir3 . logout ?>" method="POST">
                <button>ログアウト</button>
                <input type="hidden" name="logout" value="logout">
            </form>

        <?php else: ?>

            <!-- <a href="./member_regist.php"><button>新規登録</button></a> -->
            <a href="<?= dir2 . userRegisterFormPage ?>"><button>新規登録</button></a>
            <a href="<?= dir3 . loginPage ?>"><button>ログイン</button></a>

        <?php endif ; ?>

    </header>


    <section>
        <p>keiziban</p>
    </section>

    
</body>
</html>