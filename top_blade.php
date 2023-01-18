<?php

session_start();

require_once("./config.php");
require_once("./App/MemberLogic.php");

use App\MemberLogic;

// ログインをしている場合、ログイン情報を格納。
// ログインをしていない場合はnull
$member_info = isset($_SESSION['login_member']) ? (array) $_SESSION['login_member'] : null;

// ログインユーザ、ゲスト共用ページのため、trueを指定
$login_flg = MemberLogic::checkAuthenticated(true);

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

            <span>ようこそ、<?= $member_info['name_sei'] . $member_info['name_mei'] ?>さん</span>
            <a href="<?= dir4 . threadListPage ?>"><button>スレッド一覧</button></a>

            <a href="<?= dir4 . threadRegisterFormPage?>"><button>新規スレッド作成</button></a>

            <form style="display: inline" action="<?= dir3 . logout ?>" method="POST">
                <button>ログアウト</button>
                <input type="hidden" name="logout" value="logout">
            </form>

        <?php else: ?>
            <a href="<?= dir4 . threadListPage ?>"><button>スレッド一覧</button></a>
            <a href="<?= dir2 . memberRegisterFormPage ?>"><button>新規会員登録</button></a>
            <a href="<?= dir3 . loginPage ?>"><button>ログイン</button></a>

        <?php endif ; ?>


        

    </header>

    <section>
        <p>keiziban</p>

        <?php if ($login_flg): ?>
            <a style="display: block; margin-top: 100px"><button>退会</button></a>
        <?php endif; ?>
    </section>


    
</body>
</html>