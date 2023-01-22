<?php

session_start();
require_once(__DIR__ . '/../config.php');
require_once("../function.php");


use App\Token;

$last_name = FormValueRetention('last_name');
$first_name = FormValueRetention('first_name');
$sex = FormValueRetention('sex');
$prefecture = FormValueRetention('prefecture');
$other_address = FormValueRetention('other_address');
$email = FormValueRetention('email');

if (isset($_SESSION['err']))
{
    $session_msgs = $_SESSION['err'];
}
$_SESSION = array();
?>

<form action="<?= memberRegisterConfirmPage ?>" method="POST">
        <h2>会員登録フォーム</h2>
        <p>
            <span>ID</span>
            <span>登録後に自動採番</span>
        </p>
        <p>
            <span>氏名</span>
            <span>姓</span>
            <input type="text" name="last_name" value="<?php if(isset($last_name) ){ echo $last_name; } ?>">
            <span>名</span>
            <input type="text" name="first_name" value="<?php if(isset($first_name) ){ echo $first_name; } ?>">
        </p>

        <?php /*if(!array_key_exists('csrf_token', $session_msgs)): */?>
        <?php if(isset($session_msgs)): ?>
            <?php foreach($session_msgs as $msg): ?>
                <p style="color: red;"><?= $msg ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <p>
            <span>性別</span>
            <input type="radio" name="sex" value="0" <?php if (isset($sex) && $sex == "0") { echo "checked";} ?>>
            <label for="">男性</label>
            <input type="radio" name="sex" value="1" <?php if (isset($sex) && $sex == "1") { echo 'checked';} ?>>
            <label for="">女性</label>
        </p>

        <p>
            <span>住所</span>
            <label for="">都道府県</label>
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
            <input type="email" name="email" value="<?php if(isset($email) ){ echo $email; } ?>">
        </p>

        <p>
            <input type="hidden" name="csrf_token" value="<?= Token::create(); ?>">
        </p>

        <?php if (isset($_SESSION['path'])): ?>
            <?= $_SESSION['path'] ?>
        <?php endif; ?>

        <button>確認画面へ</button>
        <button><a href="../<?= topPage ?>">トップに戻る</a></button>
</form>