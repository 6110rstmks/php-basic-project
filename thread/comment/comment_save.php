<?php

session_start();

require_once(__DIR__ . '/../../config.php');


use App\CommentLogic;
use App\Database;
use App\Token;

// ログインしているメンバのIDを取得
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member'][0]['id'];
    // $member_id = $_SESSION['login_member']->id;
}


$comment = filter_input(INPUT_POST, "comment");
$thread_id = filter_input(INPUT_POST, "thread_id");


$pdo = Database::getInstance();
$commentLogic = new CommentLogic($pdo); 

$err = [];

if ($comment == '')
{
    $err['comment_required'] = 'コメントを入力してください';
}

// if (strlen($comment) >= 501)
// {
//     $err['other_address_string_limit'] = '500文字以内に収めてください';
// } 
// // elseif (mb_strlen($comment) > 501)
// // {
// //     $err['other_address_string_limit'] = '500文字以内に収めてください';
// // }

$len = mb_strlen($comment, "UTF-8");
$wdt = mb_strwidth($comment, "UTF-8");

if($len == $wdt) {
    // すべて半角の場合

    if (strlen($comment) >= 501)
    {
        $_SESSION['err']['other_address_string_limit'] = 'コメントの入力は500文字以下である必要があります';
        $err_flg = true;
    }

} elseif($len * 2 == $wdt) {
// すべて全角の場合
    if (mb_strlen($comment) >= 501)
    {
        $zenkakuzz = mb_strlen($comment);
        $_SESSION['err']['other_address_string_limit'] = 'コメントの入力は500文字以下である必要があります';
        $err_flg = true;
    }

} else {
// 全角・半角が混在している場合

}
    
if ($err_flg)
{

    header('Location: ../'. threadDetail . '?id=' .  $thread_id );
    exit();
}

$commentLogic->createComment($member_id, $thread_id, $comment);
header('Location: ../'. threadDetail . '?id=' .  $thread_id );



