<?php

session_start();

require_once(__DIR__ . '/../../config.php');


use App\CommentLogic;
use App\LikeLogic;
use App\Database;
use App\Token;

$pdo = Database::getInstance();
$likeLogic = new LikeLogic($pdo); 

// ログインしているメンバのIDを取得
if (isset($_SESSION['login_member']))
{
    $member_id = $_SESSION['login_member'][0]['id'];
    // $member_id = $_SESSION['login_member']->id;
}

/**
 * @var int
 */
$comment_id = filter_input(INPUT_POST, "comment_id");

// 元のページに戻るためのthread_id
$thread_id = filter_input(INPUT_POST, "thread_id");

/**
 * likes tableにめんばidとcomment_idをもったレコードがあるか確認
 * あれば、trueなければfalseを返す
 * @var bool
 */
$like_bool = $likeLogic->checkLikeRecord($member_id, $comment_id);

// trueであればlikeを削除
if ($like_bool)
{
    $likeLogic->deleteLikeRecord($member_id, $comment_id);

} else {
    $likeLogic->createLikeRecord($member_id, $comment_id);
}


header('Location: ../'. threadDetail . '?id=' .  $thread_id );



