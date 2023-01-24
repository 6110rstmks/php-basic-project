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
 * likes tableにmember_idとcomment_idをもったレコードがあるか確認
 * あれば、trueなければfalseを返す。
 * 現在ログインしているメンバがそのいいねをlikeしたかどうか判別する
 * @var bool
 */
$like_bool = $likeLogic->checkLikeRecord($member_id, $comment_id);

// trueであればlikeレコードを削除
if ($like_bool)
{
    $likeLogic->deleteLikeRecord($member_id, $comment_id);

} else {

    // trueでなければ新規でいいねレコードを作成
    $likeLogic->createLikeRecord($member_id, $comment_id);
}

// もとのスレッド詳細ページへ
header('Location: ../'. threadDetail . '?id=' .  $thread_id );



