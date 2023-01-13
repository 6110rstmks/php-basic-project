<?php

session_start();

require_once("../config.php");
require_once('../App/UserLogic.php');
require_once('../App/ThreadLogic.php');
require_once('../App/Database.php');

use App\UserLogic;
use App\ThreadLogic;
use App\Database;

$auth_flg = UserLogic::checkAuthenticated(true);

// ワードからスレッドを取得する
if (isset($_POST['word']))
{
    $word = $_POST['word'];

    $pdo = Database::getInstance();

    $threadLogic = new ThreadLogic($pdo);
    $threads = $threadLogic->searchThread($word);
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
    <?php if ($auth_flg): ?>
        <a href="<?= threadRegisterFormPage ?>"><button>新規作成</button></a>
    <?php endif;?>
    <form method="POST">
        <input type="text" name="word" id="">
        <button>スレッド検索</button>
    </form>

    <?php if (isset($threads)): ?>
        <?php foreach($threads as $thread): ?>
            <div>
                <span>ID</span><?= $thread['id']?>
                <span><?= $thread['title'] ?></span>
                <span><?= $thread['created_at']?></span>
            </div>
        <?php endforeach; ?>
    <?php endif;?>


    <button><a href="../<?= topPage ?>">トップに戻る</a></button>
</body>
</html>

