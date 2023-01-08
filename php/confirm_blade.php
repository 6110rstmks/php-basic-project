<?php

require_once("./config.php");

$prefectures = array('北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県');

$first_name = filter_input(INPUT_POST, "first_name");
$last_name = filter_input(INPUT_POST, "last_name");
$password = filter_input(INPUT_POST, "password");

$sex = filter_input(INPUT_POST, "sex");

$prefecture = filter_input(INPUT_POST, "prefecture");

$password_cnf = filter_input(INPUT_POST, "password_cnf");

$email = filter_input(INPUT_POST, "email");


// ---last_name---

// ２１文字以上入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (strlen($last_name) >= 21) {
    // 確認画面にリダイレクトする
    $err['last_name_count'] = '入力は 21 文字以上である必要があります';
    header('Location: remember_regist.php');
    exit;
}

// 「"7;d"''2;"」などの記号の文字列を入力してもエラーにならないか

if (mb_strlen($last_name) == mb_strwidth($last_name) || preg_match('(;|[a-z])', $last_name) === 1)
{
    
}

//空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($last_name))
{
    $err['last_name_required'] = '氏名（姓）は必須入力です。';
}

// ---first_name

//空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($first_name))
{
    $err['first_name_required'] = '氏名（名）は必須入力です。';
}




if (!isset($sex))
{
    $err['sex_required'] = '氏名（姓）は必須入力です。';
}

if (!isset($password))
{
    $err['password_required'] = 'パスワードは必須入力です。';
}

if (!isset($password_cnf))
{
    $err['first_name_required'] = '氏名（姓）は必須入力です。';
}



if ($sex != "男性" || $sex != "女性")
{
    $err['sex_err'] = "性別は男性もしくは女性を選択してください";
}

if (empty($_POST['prefecture'])) {
    // 都道府県が選択されなかった場合
    $_SESSION['error'] = '都道府県を選択してください。';
    header('Location: remember_regist.php');
    exit;
}

if (!in_array($_POST['prefecture'], $prefectures)) {
    // 47 都道府県以外の値が選択された場合
    $_SESSION['error'] = '都道府県を正しく選択してください。';
    header('Location: remember_regist.php');
    exit;
}




if (count($err) > 0)
{
    $_SESSION = $err;
    header('Location: remember_regist.php');
}

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
    <h2>会員登録確認画面</h2>

    <div>氏名</div>
    <span style="display: inline"><?= $last_name?></span>
    <span style="display: inline"><?php echo $first_name; ?></span>

    <div>性別</div>
    <div><?= $sex ?></div>

    <div>住所</div>
    <div><?= $prefecture ?></div>

    <div>パスワード</div>
    <div>セキュリティのため非表示</div>

    <div>メールアドレス</div>
    <div><?= $email ?></div>

    <button><a href="./<?= kanryougamen ?>">完了画面</a></button>
    <button><a href="./remember_regist.php">戻る</a></button>
</body>
</html>