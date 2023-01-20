<?php

session_start();

require_once(__DIR__ . '/../../config.php');


use App\CommentLogic;
use App\Database;
use App\Token;

// ログインしているメンバのIDを取得
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member']['id'];
    // $member_id = $_SESSION['login_member']->id;
}

/**
 * @var int
 */
$comment_id = filter_input(INPUT_POST, "comment_id");

// 元のページに戻るためのthread_id
$thread_id = filter_input(INPUT_POST, "thread_id");


$pdo = Database::getInstance();
$commentLogic = new CommentLogic($pdo); 

$err = [];

if ($comment == '')
{
    $err['comment_required'] = 'コメントを入力してください';
}

if (strlen($comment) >= 501)
{
    $err['other_address_string_limit'] = '500文字以内に収めてください';
}

if (count($err) > 0)
{

    $_SESSION['err'] = $err;
    header('Location: ../'. threadDetail . '?id=' .  $thread_id );
    exit();
}

$commentLogic->createComment($member_id, $thread_id, $comment);
header('Location: ../'. threadDetail . '?id=' .  $thread_id );



