<?php

session_start();

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

$sql = 'SELECT * FROM members WHERE true';

//  新規の検索条件でやったとき乱数を作成
// これは何にしようするかというと

if (count($_POST))
{
    // $kensaku_flg = true;
    $token = bin2hex(random_bytes(32));

}

// 検索idの指定がある場合
if (!empty($_POST['id']))
{
    $sql .= " AND id = :id";
}

// 検索フォームにて男性のみの指定がある場合
if (isset($_POST['male']) && !isset($_POST['female']))
{
    $sql .= " AND gender = 0";
    
} elseif (!isset($_POST['male']) && isset($_POST['female']))
{
    // 女性のみの指定がある場合
    $sql .= " AND gender = 1";


} elseif (isset($_POST['male']) && isset($_POST['female']))
{
    // 男性、女性、両方の指定がある場合
    $sql .= " AND (gender = 1 OR gender = 0)";

}

if (!empty($_POST['prefecture']))
{
    $sql .= " AND pref_name = :pref_name";
}


// 検索フォームにてフリーワードの指定がある場合
if (!empty($_POST['free_word']))
{
    $sql .= " AND (name_sei Like :free_word1 OR name_mei Like :free_word2 OR email LIKE :free_word3)";
}


//-----------------------------------
// 昇順　降順toggle

// 昇順降順のtoggleボタンを押した場合
if (isset($_POST['order_toggle']))
{

    // このif文より上の行で作成した$sqlを破棄して$_POSTの値を使用
    $sql = $_SESSION['sql'];

    // ASCの文字列をsql文の中に持つ場合（ボタンを押す前の順番が昇順の場合）
    // if (strpos($_SESSION['sql'], "ASC") !== false)
    if (strpos($sql, "ASC") !== false)
    {
        // sql文からASCを削除してDESCに変更
        $sql = str_replace('ASC', 'DESC', $sql);
    } elseif (strpos($sql, "DESC") !== false)
    {
        $sql = str_replace('DESC', 'ASC', $sql);   
    }
} else {
    $sql .= " ORDER BY id DESC";
}



//----------pagerのための処理

// メンバ数を取得。
// ただし検索フォームに値が

// if (count($_POST) === 0 && isset($_GET['pager']))
// {
//     $ttl_member = $_SESSION['temporary_ttl_member'];

// } else {
//     $ttl_member = $memberLogic->CountSearchMember($sql, $_POST);
//     $_SESSION['temporary_ttl_member'] = $ttl_member;
// }

$ttl_member = $memberLogic->CountSearchMember($sql, $_POST);
// $_SESSION['temporary_ttl_member'] = $ttl_member;

// if (count($_POST) > 0)
// {
//     $_SESSION['temporary_ttl_member'] = $ttl_member;
// }

// if ($kensaku_flg)
// {
//     $_SESSION['temporary_ttl_member'] = $ttl_member;
// }

// 検索条件でのメンバ数を取得
// そしてそれを保存



//　メンバのページャーの数を取得

$member_pager_ttl = (int) ceil(($ttl_member) / 10);

if (isset($_GET['pager']))
{
    $now_member_pager = (int) $_GET['pager'];

    // 検索フォームから検索した場合に前回のsqlを使用する。
    $sql = $_SESSION['sql'];
    // 上記のとき（検索フォームから検索した場合）

} else {
    $now_member_pager = 1;
}

$prev_member_pager = $now_member_pager === 1 ? null : max($now_member_pager - 1, 1); 
$next_member_pager = $now_member_pager === $member_pager_ttl || $member_pager_ttl == 1 ? null : min($now_member_pager + 1, $ttl_member); 

//---------------------------------------------------------------------

// ある条件の検索のために作成したsqlに対して昇順、降順のtoggleするために使用。
// またある条件の検索して取得した検索結果の行のページャーを移動した場合のsql文を取得するために使用
// sessionに保存
// $_SESSION['sql']一つ前の$sqlの内容を保存するための、退避用変数として利用する。
$_SESSION['sql'] = $sql;

//-----------------------------

$sql .= " LIMIT 10 OFFSET :offset";

$offset = ($now_member_pager - 1) * 10;


$members = $memberLogic->searchMember($sql, $_POST, $offset);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <link rel="stylesheet" href="../style.css"></link>
</head>
<body>
    <div style="display: flex;">
        <div>会員一覧</div>
        <button><a href="<?= adminTopPage ?>">トップへ戻る</a></button>
        <hr>
    </div>

    <button style="margin-top: 100px">
        <a href="<?= memberRegisterFormPage ?>">会員登録</a>
    </button>
    <!-- <form method="POST" action="member_list.php?pager=1"> -->
    <form method="POST" action="member_list.php">
        <table>

            <tr>
                <td>ID</td>
                <td><input type="number" name="id" id=""></td>
            </tr>
            <tr>
                <td>性別</td>
                <td>
                    <input type="checkbox" name="male" value="0" <?php if (isset($sex) && $sex == "0") { echo "checked";} ?>>
                    <label for="">男性</label>
                    <input type="checkbox" name="female" value="1" <?php if (isset($sex) && $sex == "1") { echo 'checked';} ?>>
                    <label for="">女性</label>
                </td>
            </tr>
            <tr>
                <td>都道府県</td>
                <td>
                    <select id="prefectures" name="prefecture">
                        <option value="">選択してください</option>
                        <option value="北海道" <?php if (isset($prefecture) && $prefecture == "北海道") { echo "selected"; }?>>北海道</option>
                        <option value="青森県" <?php if (isset($prefecture) && $prefecture == "青森県") { echo "selected"; }?>>青森県</option>
                        <option value="岩手県" <?php if (isset($prefecture) && $prefecture == "岩手県") { echo "selected"; }?>>岩手県</option>
                        <option value="宮城県" <?php if (isset($prefecture) && $prefecture == "宮城県") { echo "selected"; }?>>宮城県</option>
                        <option value="秋田県" <?php if (isset($prefecture) && $prefecture == "秋田県") { echo "selected"; }?>>秋田県</option>
                        <option value="山形県" <?php if (isset($prefecture) && $prefecture == "山形県") { echo "selected"; }?>>山形県</option>
                        <option value="福島県" <?php if (isset($prefecture) && $prefecture == "福島県") { echo "selected"; }?>>福島県</option>
                        <option value="茨城県" <?php if (isset($prefecture) && $prefecture == "茨城県") { echo "selected"; }?>>茨城県</option>
                        <option value="栃木県" <?php if (isset($prefecture) && $prefecture == "栃木県") { echo "selected"; }?>>栃木県</option>
                        <option value="群馬県" <?php if (isset($prefecture) && $prefecture == "群馬県") { echo "selected"; }?>>群馬県</option>
                        <option value="埼玉県" <?php if (isset($prefecture) && $prefecture == "埼玉県") { echo "selected"; }?>>埼玉県</option>
                        <option value="千葉県" <?php if (isset($prefecture) && $prefecture == "千葉県") { echo "selected"; }?>>千葉県</option>
                        <option value="東京都" <?php if (isset($prefecture) && $prefecture == "東京都") { echo "selected"; }?>>東京都</option>
                        <option value="神奈川県" <?php if (isset($prefecture) && $prefecture == "神奈川県") { echo "selected"; }?>>神奈川県</option>
                        <option value="新潟県" <?php if (isset($prefecture) && $prefecture == "新潟県") { echo "selected"; }?>>新潟県</option>
                        <option value="石川県" <?php if (isset($prefecture) && $prefecture == "石川県") { echo "selected"; }?>>石川県</option>
                        <option value="福井県" <?php if (isset($prefecture) && $prefecture == "福井県") { echo "selected"; }?>>福井県</option>
                        <option value="山梨県" <?php if (isset($prefecture) && $prefecture == "山梨県") { echo "selected"; }?>>山梨県</option>
                        <option value="長野県" <?php if (isset($prefecture) && $prefecture == "長野県") { echo "selected"; }?>>長野県</option>
                        <option value="岐阜県" <?php if (isset($prefecture) && $prefecture == "岐阜県") { echo "selected"; }?>>岐阜県</option>
                        <option value="静岡県" <?php if (isset($prefecture) && $prefecture == "静岡県") { echo "selected"; }?>>静岡県</option>
                        <option value="愛知県" <?php if (isset($prefecture) && $prefecture == "愛知県") { echo "selected"; }?>>愛知県</option>
                        <option value="三重県" <?php if (isset($prefecture) && $prefecture == "三重県") { echo "selected"; }?>>三重県</option>
                        <option value="滋賀県" <?php if (isset($prefecture) && $prefecture == "滋賀県") { echo "selected"; }?>>滋賀県</option>
                        <option value="京都府" <?php if (isset($prefecture) && $prefecture == "京都府") { echo "selected"; }?>>京都府</option>
                        <option value="大阪府" <?php if (isset($prefecture) && $prefecture == "大阪府") { echo "selected"; }?>>大阪府</option>
                        <option value="兵庫県" <?php if (isset($prefecture) && $prefecture == "兵庫県") { echo "selected"; }?>>兵庫県</option>
                        <option value="奈良県" <?php if (isset($prefecture) && $prefecture == "奈良県") { echo "selected"; }?>>奈良県</option>
                        <option value="和歌山県" <?php if (isset($prefecture) && $prefecture == "和歌山県") { echo "selected"; }?>>和歌山県</option>
                        <option value="鳥取県" <?php if (isset($prefecture) && $prefecture == "鳥取県") { echo "selected"; }?>>鳥取県</option>
                        <option value="岡山県" <?php if (isset($prefecture) && $prefecture == "岡山県") { echo "selected"; }?>>岡山県</option>
                        <option value="広島県" <?php if (isset($prefecture) && $prefecture == "広島県") { echo "selected"; }?>>広島県</option>
                        <option value="山口県" <?php if (isset($prefecture) && $prefecture == "山口県") { echo "selected"; }?>>山口県</option>
                        <option value="徳島県" <?php if (isset($prefecture) && $prefecture == "徳島県") { echo "selected"; }?>>徳島県</option>
                        <option value="香川県" <?php if (isset($prefecture) && $prefecture == "香川県") { echo "selected"; }?>>香川県</option>
                        <option value="愛媛県" <?php if (isset($prefecture) && $prefecture == "愛媛県") { echo "selected"; }?>>愛媛県</option>
                        <option value="高知県" <?php if (isset($prefecture) && $prefecture == "高知県") { echo "selected"; }?>>高知県</option>
                        <option value="福岡県" <?php if (isset($prefecture) && $prefecture == "福岡県") { echo "selected"; }?>>福岡県</option>
                        <option value="佐賀県" <?php if (isset($prefecture) && $prefecture == "佐賀県") { echo "selected"; }?>>佐賀県</option>
                        <option value="長崎県" <?php if (isset($prefecture) && $prefecture == "長崎県") { echo "selected"; }?>>長崎県</option>
                        <option value="熊本県" <?php if (isset($prefecture) && $prefecture == "熊本県") { echo "selected"; }?>>熊本県</option>
                        <option value="大分県" <?php if (isset($prefecture) && $prefecture == "大分県") { echo "selected"; }?>>大分県</option>
                        <option value="宮崎県" <?php if (isset($prefecture) && $prefecture == "宮崎県") { echo "selected"; }?>>宮崎県</option>
                        <option value="鹿児島県" <?php if (isset($prefecture) && $prefecture == "鹿児島県") { echo "selected"; }?>>鹿児島県</option>
                        <option value="沖縄県" <?php if (isset($prefecture) && $prefecture == "沖縄県") { echo "selected"; }?>>沖縄県</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>フリーワード</td>
                <td><input type="text" name="free_word" id=""></td> 
            </tr>
        </table>    
        <button>検索する</button> 
    </form>

    <table>
        <tr>
            <th style="cursor: pointer">
                <form method="POST">
                    <input type="hidden" name="order_toggle">
                    <button>ID▼</button>
                </form>
            </th>
            <th>氏名</th>
            <th>性別</th>
            <th>住所</th>
            <th>
                <form method="POST">
                    <input type="hidden" name="order_toggle">
                    <button>登録日時▼</button>
                </form>
            </th>
            <th>編集</th>
        </tr>
        <?php foreach($members as $member): ?>
            <tr>
                <td><?= $member['id'] ?></td>
                <td><?= $member['name_sei'] . $member['name_mei'] ?></td>
                <td>
                    <?php if ($member['gender'] === 0): ?>
                        男性
                    <?php else:?>
                        女性
                    <?php endif;?>
                </td>
                <td><?= $member['pref_name'] . $member['address']?></td>
                <td><?= $member['created_at'] ?></td>
                <td><a href="<?= memberEditPage . '?id=' . $member['id'] ?>">編集</a></td>
            </tr>
        <?php endforeach;?>
    </table>

    <!-- ページャー -->

    <section style="margin-top: 50px; display: flex" class="pager">

        <!-- ＜前へ＞の部分 -->
        <?php if (isset($prev_member_pager)): ?>
            <form action="" method="GET">
                <button href="">前へ></button>
                <input type="hidden" name="pager" value="<?= $now_member_pager - 1?>">
            </form>
        <?php endif;?>

        <!-- ここから下は数字を表示するHTML部分 -->

        <!-- 現在の２つ前のページ -->
        <?php if ($now_member_pager ===  $member_pager_ttl && $member_pager_ttl >= 3): ?>
            <form action="">
                <button class="member-pager" style="border: 1px black solid"><?= $now_member_pager - 2 ?></button>
                <input type="hidden" name="pager" value="<?= $now_member_pager - 2?>">
            </form>
        <?php endif;?>

        <!-- 現在の一つ前のページ -->
        <?php if (isset($prev_member_pager)): ?>
            <form action="">
                <button style="border: 1px black solid"><?= $prev_member_pager ?></button>
                <input type="hidden" name="pager" value="<?= $prev_member_pager ?>">
            </form>
        <?php endif; ?>

        <!-- 現在のページ -->
        <button class="member-pager" style="border: 1px black solid; background-color: gray;"><?= $now_member_pager + 0 ?></button>

        <!-- 現在の一つ次のページ -->
        <?php if (isset($next_member_pager)): ?>
            <form action="">
                <button class="member-pager" style="border: 1px black solid"><?= $next_member_pager ?></button>
                <input type="hidden" name="pager" value="<?= $next_member_pager ?>">
            </form>
        <?php endif; ?>

        <!-- 現在の２つ次のページ -->
        <?php if ($now_member_pager === 1 && $member_pager_ttl >= $now_member_pager + 2): ?>
            <form action="">
                <button class="member-pager" style="border: 1px black solid"><?= $now_member_pager + 2 ?></button>
                <input type="hidden" name="pager" value="<?= $now_member_pager + 2?>">
            </form>
        <?php endif;?>

        <!-- ＜後へ＞の部分 -->
        <?php if (isset($next_member_pager)): ?>
            <form action="" method="GET">
                <button>次へ></button>
                <input type="hidden" name="pager" value="<?= $next_member_pager?>">
            </form>
        <?php endif;?>
    </section>
</body>
</html>