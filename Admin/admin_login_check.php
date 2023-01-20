<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;

// ディレクトリ名(admin)をaではなくAにすると
// config.phpの$class = trim($class, "App\\");でエラーが生じる。
use App\adminLogic;

$pdo = Database::getInstance();

$login_id = filter_input(INPUT_POST, 'login_id');

$password = filter_input(INPUT_POST, 'password');

// バリデーションにひっかかったとき
$_SESSION['login_id'] = $login_id;

$err = [];

if (empty($login_id))
{
    $err['login_id_required'] = 'ログインIDは必須入力です。';
} elseif (strlen($login_id) < 7 || strlen($login_id) > 10) {
    $err['login_id_string_limit'] = 'ログインidは7文字から10文字の間です。';
}



if (empty($password))
{
    $err['password_required'] = 'パスワードは必須入力です。';

} elseif (strlen($password) < 21 || strlen($password) > 7) {
    $err['password_string_limit'] = 'パスワードは8文字から20文字の間です。';
}

$adminLogic = new adminLogic($pdo);

/**
 * 空のarrayがかえってきた場合ログインに失敗
 * @var array
 */
$admin = $adminLogic->login($login_id, $password); 

if (!empty($login_id) && !empty($password) && empty($admin))
{
    $err['match_err'] = 'ログインIDもしくはパスワードが間違っています';

}

if (count($err) > 0)
{
    $_SESSION['err'] = $err;
    header('Location:' . adminLoginPage);

} else {
    session_regenerate_id(true);

    header('Location:' . adminTopPage);
}


