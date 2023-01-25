<?php

session_start();

// 現在のページ番号を取得

if (isset($_POST['pager']))
{
    $now_member_pager = (int) $_POST['pager'];

    // 検索フォームから検索した場合に前回のsqlを使用する。
    // 上記のとき（検索フォームから検索した場合）

} else {

    $now_member_pager = 1;
}

// メンバの数を取得（その前に検索した条件で）


// 検索フォームから検索した結果をページャーで遷移する場合、前回行ったsql文を取得
// if (isset($_SESSION['temp_sql']))
// {
//     $sql = $_SESSION['temp_sql'];
// }

// member_list2.phpにわたすための現在のページ番号をセッションに保存
$_SESSION['now_member_pager'] = $now_member_pager;

//　メンバの数をセッションに格納してmember_list.phpへ渡す
header('Location:member_list2.php');

?>