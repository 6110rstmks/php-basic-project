<?php

session_start();
require_once(__DIR__ . '/../config.php');
require_once("../function.php");
use App\Token;

use App\Database;
use App\MemberLogic;

$pdo = Database::getInstance();
$memberLogic = new MemberLogic($pdo);

// in development
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    
    if ($_SERVER['REQUEST_URI'] == '/php-kisokadai/admin/member_regist_blade.php') {
        $file = 'regist';
    } else {
        $file = 'edit';
    }

} else {
    // in product
    if ($_SERVER['REQUEST_URI'] == '/Admin/member_regist_blade.php') {
        $file = 'regist';
    } else {
        $file = 'edit';
    }
}

// member_confirm_blade.phpで使用する。
$_SESSION['file'] = $file;

if (isset($_GET['id']))
{
    $id = (int) $_GET['id'];
}

$member = $memberLogic->getMemberById($id);


if (
    isset($_SESSION['last_name']) 
    || isset($_SESSION['first_name']) 
    || isset($_SESSION['sex_name']) 
    || isset($_SESSION['prefecture_name']) 
    || isset($_SESSION['other_address'])
    || isset($_SESSION['email'])
    )
{
    $err_redirect_flg = true;
} else {
    $err_redirect_flg = false;
}

$last_name = FormValueRetention('last_name');
$first_name = FormValueRetention('first_name');
$sex = FormValueRetention('sex');
$prefecture = FormValueRetention('prefecture');
$other_address = FormValueRetention('other_address');
$email = FormValueRetention('email');

$initial_name_sei = $member['name_sei'];
$initial_name_mei = $member['name_mei'];
$initial_gender = $member['gender'];
$initial_pref_name = $member['pref_name'];
$initial_address = $member['address'];
$initial_email = $member['email'];

if (isset($_SESSION['err']))
{
    $session_msgs = $_SESSION['err'];
    unset($_SESSION['err']);
}

if ($file == 'regist')
{
    $title = '会員登録';
    $id = "登録後に自動採番";
} else {
    $title = '会員編集';
}



?>
<div style="display: flex;">

    <div><?= $title ?></div>
    <button style="margin-left: 240px"><a href="<?= memberList ?>">一覧へ戻る</a></button>
</div>

<form action="<?= memberConfirmPage ?>" method="POST">
        <p>
            <span>ID</span>
            <span><?= $id ?></span>
        </p>
        <p>
            <span>氏名</span>
            <span>姓</span>
            <?php if ($file == 'regist'): ?>
                <input type="text" name="last_name" value="<?php if($err_redirect_flg){ echo $last_name; } ?>">
            <?php else:?>
                <input type="text" name="last_name" value="<?php if($err_redirect_flg){ echo $last_name; } else { echo $initial_name_sei; } ?>">
            <?php endif;?>

            <span>名</span>
            <?php if ($file == 'regist'): ?>
                <input type="text" name="first_name" value="<?php if(isset($first_name) ){ echo $first_name; } ?>">
            <?php else:?>
                <input type="text" name="first_name" value="<?php if($err_redirect_flg){ echo $first_name; } else { echo $initial_name_mei; } ?>">
            <?php endif;?>


        </p>

        <?php /*if(!array_key_exists('csrf_token', $session_msgs)): */?>
        <?php if(isset($session_msgs)): ?>
            <?php foreach($session_msgs as $msg): ?>
                <p style="color: red;"><?= $msg ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <p>
            <span>性別</span>
            <?php if ($file == 'regist'): ?>
                <input type="radio" name="sex" value="0" <?php if (isset($sex) && $sex == "0") { echo "checked";} ?>>
            <?php else: ?>
                <input type="radio" name="sex" value="0" <?php if ((!$err_redirect_flg && $initial_gender == 0) || ($err_redirect_flg && $sex == "0")) { echo "checked";} ?>>
            <?php endif; ?>
            <label for="">男性</label>


            <?php if ($file == 'regist'): ?>
                <input type="radio" name="sex" value="1" <?php if (isset($sex) && $sex == "1") { echo "checked";} ?>>
            <?php else: ?>
                <input type="radio" name="sex" value="1" <?php if ((!$err_redirect_flg && $initial_gender == 1) || ($err_redirect_flg && $sex == "1")) { echo "checked";} ?>>
            <?php endif; ?>

            <label for="">女性</label>
        </p>

        <p>
            <span>住所</span>
            <label for="">都道府県</label>
                <?php if ($file == 'regist'): ?>
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
                <?php else: ?>
                    <select id="prefectures" name="prefecture">
                        <option value="">選択してください</option>
                        <option value="北海道" <?php if ((!$err_redirect_flg && $initial_pref_name == "北海道") || ($err_redirect_flg && $prefecture == "北海道")) { echo "selected"; }?>>北海道</option>
                        <option value="青森県" <?php if ((!$err_redirect_flg && $initial_pref_name == "青森県") || ($err_redirect_flg && $prefecture == "青森県")) { echo "selected"; }?>>青森県</option>
                        <option value="岩手県" <?php if ((!$err_redirect_flg && $initial_pref_name == "岩手県") || ($err_redirect_flg && $prefecture == "岩手県")) { echo "selected"; }?>>岩手県</option>
                        <option value="宮城県" <?php if ((!$err_redirect_flg && $initial_pref_name == "宮城県") || ($err_redirect_flg && $prefecture == "宮城県")) { echo "selected"; }?>>宮城県</option>
                        <option value="秋田県" <?php if ((!$err_redirect_flg && $initial_pref_name == "秋田県") || ($err_redirect_flg && $prefecture == "秋田県")) { echo "selected"; }?>>秋田県</option>
                        <option value="山形県" <?php if ((!$err_redirect_flg && $initial_pref_name == "山形県") || ($err_redirect_flg && $prefecture == "山形県")) { echo "selected"; }?>>山形県</option>
                        <option value="福島県" <?php if ((!$err_redirect_flg && $initial_pref_name == "福島県") || ($err_redirect_flg && $prefecture == "福島県")) { echo "selected"; }?>>福島県</option>
                        <option value="茨城県" <?php if ((!$err_redirect_flg && $initial_pref_name == "茨城県") || ($err_redirect_flg && $prefecture == "茨城県")) { echo "selected"; }?>>茨城県</option>
                        <option value="栃木県" <?php if ((!$err_redirect_flg && $initial_pref_name == "栃木県") || ($err_redirect_flg && $prefecture == "栃木県")) { echo "selected"; }?>>栃木県</option>
                        <option value="群馬県" <?php if ((!$err_redirect_flg && $initial_pref_name == "群馬県") || ($err_redirect_flg && $prefecture == "群馬県")) { echo "selected"; }?>>群馬県</option>
                        <option value="埼玉県" <?php if ((!$err_redirect_flg && $initial_pref_name == "埼玉県") || ($err_redirect_flg && $prefecture == "埼玉県")) { echo "selected"; }?>>埼玉県</option>
                        <option value="千葉県" <?php if ((!$err_redirect_flg && $initial_pref_name == "千葉県") || ($err_redirect_flg && $prefecture == "千葉県")) { echo "selected"; }?>>千葉県</option>
                        <option value="東京都" <?php if ((!$err_redirect_flg && $initial_pref_name == "東京都") || ($err_redirect_flg && $prefecture == "東京都")) { echo "selected"; }?>>東京都</option>
                        <option value="神奈川県" <?php if ((!$err_redirect_flg && $initial_pref_name == "神奈川県") || ($err_redirect_flg && $prefecture == "神奈川県")) { echo "selected"; }?>>神奈川県</option>

                        <option value="新潟県" <?php if ((!$err_redirect_flg && $initial_pref_name == "新潟県") || ($err_redirect_flg && $prefecture == "新潟県")) { echo "selected"; }?>>新潟県</option>
                        <option value="富山県" <?php if ((!$err_redirect_flg && $initial_pref_name == "富山県") || ($err_redirect_flg && $prefecture == "富山県")) { echo "selected"; }?>>富山県</option>
                        <option value="石川県" <?php if ((!$err_redirect_flg && $initial_pref_name == "石川県") || ($err_redirect_flg && $prefecture == "石川県")) { echo "selected"; }?>>石川県</option>

                        <option value="福井県" <?php if ((!$err_redirect_flg && $initial_pref_name == "福井県") || ($err_redirect_flg && $prefecture == "福井県")) { echo "selected"; }?>>福井県</option>
                        <option value="山梨県" <?php if ((!$err_redirect_flg && $initial_pref_name == "山梨県") || ($err_redirect_flg && $prefecture == "山梨県")) { echo "selected"; }?>>山梨県</option>
                        <option value="長野県" <?php if ((!$err_redirect_flg && $initial_pref_name == "長野県") || ($err_redirect_flg && $prefecture == "長野県")) { echo "selected"; }?>>長野県</option>
                        <option value="岐阜県" <?php if ((!$err_redirect_flg && $initial_pref_name == "岐阜県") || ($err_redirect_flg && $prefecture == "岐阜県")) { echo "selected"; }?>>岐阜県</option>
                        <option value="静岡県" <?php if ((!$err_redirect_flg && $initial_pref_name == "静岡県") || ($err_redirect_flg && $prefecture == "静岡県")) { echo "selected"; }?>>静岡県</option>
                        <option value="愛知県" <?php if ((!$err_redirect_flg && $initial_pref_name == "愛知県") || ($err_redirect_flg && $prefecture == "愛知県")) { echo "selected"; }?>>愛知県</option>
                        <option value="三重県" <?php if ((!$err_redirect_flg && $initial_pref_name == "三重県") || ($err_redirect_flg && $prefecture == "三重県")) { echo "selected"; }?>>三重県</option>
                        <option value="滋賀県" <?php if ((!$err_redirect_flg && $initial_pref_name == "滋賀県") || ($err_redirect_flg && $prefecture == "滋賀県")) { echo "selected"; }?>>滋賀県</option>
                        <option value="京都府" <?php if ((!$err_redirect_flg && $initial_pref_name == "京都府") || ($err_redirect_flg && $prefecture == "京都府")) { echo "selected"; }?>>京都府</option>
                        <option value="大阪府" <?php if ((!$err_redirect_flg && $initial_pref_name == "大阪府") || ($err_redirect_flg && $prefecture == "大阪府")) { echo "selected"; }?>>大阪府</option>
                        <option value="兵庫県" <?php if ((!$err_redirect_flg && $initial_pref_name == "兵庫県") || ($err_redirect_flg && $prefecture == "兵庫県")) { echo "selected"; }?>>兵庫県</option>
                        <option value="奈良県" <?php if ((!$err_redirect_flg && $initial_pref_name == "奈良県") || ($err_redirect_flg && $prefecture == "奈良県")) { echo "selected"; }?>>奈良県</option>
                        <option value="和歌山県" <?php if ((!$err_redirect_flg && $initial_pref_name == "和歌山県") || ($err_redirect_flg && $prefecture == "和歌山県")) { echo "selected"; }?>>和歌山県</option>

                        <option value="鳥取県" <?php if ((!$err_redirect_flg && $initial_pref_name == "鳥取県") || ($err_redirect_flg && $prefecture == "鳥取県")) { echo "selected"; }?>>鳥取県</option>
                        <option value="島根県" <?php if ((!$err_redirect_flg && $initial_pref_name == "島根県") || ($err_redirect_flg && $prefecture == "島根県")) { echo "selected"; }?>>島根県</option>
                        <option value="岡山県" <?php if ((!$err_redirect_flg && $initial_pref_name == "岡山県") || ($err_redirect_flg && $prefecture == "岡山県")) { echo "selected"; }?>>岡山県</option>
                        <option value="広島県" <?php if ((!$err_redirect_flg && $initial_pref_name == "広島県") || ($err_redirect_flg && $prefecture == "広島県")) { echo "selected"; }?>>広島県</option>
                        <option value="山口県" <?php if ((!$err_redirect_flg && $initial_pref_name == "山口県") || ($err_redirect_flg && $prefecture == "山口県")) { echo "selected"; }?>>山口県</option>
                        <option value="徳島県" <?php if ((!$err_redirect_flg && $initial_pref_name == "徳島県") || ($err_redirect_flg && $prefecture == "徳島県")) { echo "selected"; }?>>徳島県</option>
                        <option value="香川県" <?php if ((!$err_redirect_flg && $initial_pref_name == "香川県") || ($err_redirect_flg && $prefecture == "香川県")) { echo "selected"; }?>>香川県</option>
                        <option value="愛媛県" <?php if ((!$err_redirect_flg && $initial_pref_name == "愛媛県") || ($err_redirect_flg && $prefecture == "愛媛県")) { echo "selected"; }?>>愛媛県</option>
                        <option value="高知県" <?php if ((!$err_redirect_flg && $initial_pref_name == "高知県") || ($err_redirect_flg && $prefecture == "高知県")) { echo "selected"; }?>>高知県</option>

                        <option value="福岡県" <?php if ((!$err_redirect_flg && $initial_pref_name == "福岡県") || ($err_redirect_flg && $prefecture == "福岡県")) { echo "selected"; }?>>福岡県</option>
                        <option value="佐賀県" <?php if ((!$err_redirect_flg && $initial_pref_name == "佐賀県") || ($err_redirect_flg && $prefecture == "佐賀県")) { echo "selected"; }?>>佐賀県</option>
                        <option value="長崎県" <?php if ((!$err_redirect_flg && $initial_pref_name == "長崎県") || ($err_redirect_flg && $prefecture == "長崎県")) { echo "selected"; }?>>長崎県</option>
                        <option value="熊本県" <?php if ((!$err_redirect_flg && $initial_pref_name == "熊本県") || ($err_redirect_flg && $prefecture == "熊本県")) { echo "selected"; }?>>熊本県</option>
                        <option value="大分県" <?php if ((!$err_redirect_flg && $initial_pref_name == "大分県") || ($err_redirect_flg && $prefecture == "大分県")) { echo "selected"; }?>>大分県</option>
                        <option value="宮崎県" <?php if ((!$err_redirect_flg && $initial_pref_name == "宮崎県") || ($err_redirect_flg && $prefecture == "宮崎県")) { echo "selected"; }?>>宮崎県</option>
                        <option value="鹿児島県" <?php if ((!$err_redirect_flg && $initial_pref_name == "鹿児島県") || ($err_redirect_flg && $prefecture == "鹿児島県")) { echo "selected"; }?>>鹿児島県</option>
                        <option value="沖縄県" <?php if ((!$err_redirect_flg && $initial_pref_name == "沖縄県") || ($err_redirect_flg && $prefecture == "沖縄県")) { echo "selected"; }?>>沖縄県</option>
                    </select>
                <?php endif;?>
            <label for="">それ以降の住所</label>
            <input type="text" name="other_address" id="" value="<?php if(isset($other_address) ){ echo $other_address; } ?>">
        </p>

        <p>
            <span>パスワード</span>
            <input type="password" name="password" id="">
        </p>

        <p>
            <span>パスワード確認</span>
            <input type="password" name="password_cnf" id="">
        </p>

        <p>
            <span>メールアドレス</span>
            <?php if ($file == 'regist'): ?>
                <input type="email" name="email" value="<?php if($err_redirect_flg){ echo $email; } ?>">
            <?php else: ?>
                    <input type="email" name="email" value="<?php if($err_redirect_flg) { echo $email; } else { echo $initial_email; } ?>">
            <?php endif;?>
        </p>

        <p>
            <input type="hidden" name="csrf_token" value="<?= Token::create(); ?>">
        </p>

        <input type="hidden" name="id" value="<?= $id ?>">

        <?php if (isset($_SESSION['path'])): ?>
            <?= $_SESSION['path'] ?>
        <?php endif; ?>

        <button>確認画面へ</button>
        <button><a href="<?= adminTopPage ?>">トップに戻る</a></button>
</form>
