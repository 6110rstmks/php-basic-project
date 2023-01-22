<?php

require_once(__DIR__ . '/../config.php');

use App\Database;
use App\MemberLogic;

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

if (isset($_POST['asc_flg']))
{

}

// 検索idからメンバを取得
if (isset($_POST['id']))
{
    $id = $_POST['id'];
}

// 性別からメンバを取得
elseif (isset($_POST['sex']))
{

}

// フリーワードからメンバを取得
elseif (isset($_POST['free_word']))
{
    $free_word = $_POST['free_word'];


    /**
     * 検索したワードがタイトルもしくはコメント内にあるメンバ一覧を取得
     * @var array|null
     */
    $members = $memberLogic->searchMember($sql);

    
} else {
    // 降順で取得
    $members = $memberLogic->getAllMembers();

}




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
    <form method="POST">
        <table>

            <tr>
                <td>ID</td>
                <td><input type="number" name="id" id=""></td>
            </tr>
            <tr>
                <td>性別</td>
                <td>
                    <input type="radio" name="sex" value="0" <?php if (isset($sex) && $sex == "0") { echo "checked";} ?>>
                    <label for="">男性</label>
                    <input type="radio" name="sex" value="1" <?php if (isset($sex) && $sex == "1") { echo 'checked';} ?>>
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
            <th>登録日時</th>
            <th>編集</th>
        </tr>
        <?php foreach($members as $member): ?>
            <tr>
                <td><?= $member['id'] ?></td>
                <td><?= $member['name_sei'] . $member['name_mei'] ?></td>
                <!-- <td><?= $member['gender'] ?></td> -->
                <td>
                    <?php if ($member['gender'] === 0): ?>
                        男性
                    <?php else:?>
                        女性
                    <?php endif;?>
                </td>
                <td><?= $member['pref_name'] . $member['address']?></td>
                <td><?= $member['created_at'] ?></td>
                <td><a href="">編集</a></td>
            </tr>
        <?php endforeach;?>
    </table>
</body>
</html>