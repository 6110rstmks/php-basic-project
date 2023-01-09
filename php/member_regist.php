<?php

session_start();
require_once("./config.php");

$session_msgs = $_SESSION;
$_SESSION = array();
$b = 'oiu';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./confirm_blade.php" method="POST">
        <h2>会員登録フォーム</h2>
        <p>
            <span>氏名</span>
            <label style="display: inline">姓</label>
            <input type="text" name="last_name" id="">
            <div>名</div>
            <input type="text" name="first_name" id="">
        </p>

        <!-- <?php if(isset($session_msgs['last_name_zenkaku'])): ?>
            <?= $session_msgs['last_name_zenkaku'] ?>
        <?php endif;?> -->

        <?php foreach($session_msgs as $msg): ?>
            <p style="color: red;"><?= $msg ?></p>
        <?php endforeach; ?>

        

        <p>
            <span>性別</span>
            <input type="radio" name="sex" value="男性" id="">
            <label for="">男性</label>
            <input type="radio" name="sex" value="女性" id="">
            <label for="">女性</label>
        </p>

        <p>
            <span>住所</span>
            <label for="">都道府県</label>
                <select id="prefectures" name="prefectures">
                    <option value="">選択してください</option>
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                </select>
            <label for="">それ以降の住所</label>
            <input type="text" name="other_address" id="">
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
            <input type="email" name="email">
        </p>

        <button>確認画面</button>
    </form>
</body>
</html>