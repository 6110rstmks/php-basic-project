<?php

session_start();
require_once('../App/UserLogic.php');

use App\UserLogic;

if (!$logout = filter_input(INPUT_POST, 'logout'))
{
    exit('不正なリクエストです。');

}

// ログインしているか判定する、セッションが切れていたらログインしてくださいとメッセージを出す。
// $result = UserLogic::checkAuthenticated();

// if (!$result) {
//     // $_SESSION['logout_msg'] = '一定期間経過したので再ログインが必要です。';
//     $msg['logout_msg'] = '一定期間経過したので再ログインが必要です。';
//     header('Location: login-form_blade.php');
//     return;
// }

// UserLogic::logout();
$_SESSION = array();


// $_SESSION['logout_msg'] = 'ログアウトが完了しました';
header('Location: top_blade.php');
