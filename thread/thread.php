<?php

session_start();

require_once("../config.php");
require_once('../App/UserLogic.php');

use App\UserLogic;


$result = UserLogic::checkAuthenticated();

if (!$result)
{
    exit("ログインが必要です。");
}


?>

<button><a href="../<?= topPage ?>">トップに戻る</a></button>