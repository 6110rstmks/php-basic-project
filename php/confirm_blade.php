<?php

session_start();
require_once("./config.php");
require_once("../App/Database.php");
require_once("../App/UserLogic.php");
require_once("../App/Token.php");


use App\UserLogic;
use App\Database;
use App\Token;

// csrf_token照合
// & 二重登録防止
Token::validate();

$_SESSION['csrf_token'] = '';


$pdo = Database::getInstance();
$userLogic = new UserLogic($pdo); 



$prefectures_array = array('北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県');

$first_name = filter_input(INPUT_POST, "first_name");
$last_name = filter_input(INPUT_POST, "last_name");
$password = filter_input(INPUT_POST, "password");

$sex = filter_input(INPUT_POST, "sex");

$prefecture = filter_input(INPUT_POST, "prefecture");
$other_address = filter_input(INPUT_POST, "other_address");

$password_cnf = filter_input(INPUT_POST, "password_cnf");

$email = filter_input(INPUT_POST, "email");

$err = [];


// ---last_name---（完）

// ２１文字以上入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (strlen($last_name) >= 21) {
    // 確認画面にリダイレクトする
    $err['last_name_count'] = '入力は 21 文字以下である必要があります';
    exit;
}

// 「"7;d"''2;"」などの記号の文字列を入力してもエラーにならないか

if (mb_strlen($last_name) == mb_strwidth($last_name) || preg_match('(;|[a-z])', $last_name) === 1)
{
    $err['last_name_zenkaku'] = '全角文字を入力してください';
}

// 空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($last_name))
{
    $err['last_name_required'] = '氏名（姓）は必須入力です。';
}

// ---first_name（完）

//空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($first_name))
{
    $err['first_name_required'] = '氏名（名）は必須入力です。';
}

// 「"7;d"''2;"」などの記号の文字列を入力してもエラーにならないか

if (mb_strlen($first_name) == mb_strwidth($first_name) || preg_match('(;|[a-z])', $first_name) === 1)
{
    $err['first_name_zenkaku'] = '全角文字を入力してください';
}

//空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($first_name))
{
    $err['last_name_required'] = '氏名（姓）は必須入力です。';
}


// ---sex（完）

// 選択なしで「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($sex))
{
    $err['sex_required'] = '性別は必須入力です。';
}

// 男性・女性以外の値をvalue値に入れて「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!($sex == "男性" || $sex == "女性"))
{
    $err['sex_validation'] = "性別は男性もしくは女性を選択してください";
}

// ---住所（都道府県）（完）

// ４７都道府県以外の値をvalue値に入れて「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!in_array($prefecture, $prefectures_array)) {
    $err['prefecture_required'] = '都道府県を正しく選択してください。';
}

// 選択なしで「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($prefecture))
{
    $err['prefecture_required'] = '都道府県を選択してください';
}

// --住所（それ以外の住所）
// 未入力でも遷移可能

// １０１文字以上入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (strlen($other_address) >= 101)
{
    $err['other_address_string_limit'] = '100文字以内に収めてください';
}


// ---password（完）

// 半角英数字以外の文字を入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (mb_strlen($password) != mb_strwidth($password))
{
    $err['password_hankaku'] = 'パスワードは半角英数字でお願いします';
}

// 8～20文字の文字入力数でない場合に「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか
if (strlen($password) < 8 || strlen($password) > 20)
{
    $err['password_string_limit'] = 'パスワードの文字数は8文字以上20文字以下でお願いします。';
}

// 空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($password))
{
    $err['password_required'] = 'パスワードは必須入力です。';
}

// ---password_cnf


// 半角英数字以外の文字を入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (mb_strlen($password_cnf) != mb_strwidth($password_cnf))
{
    $err['password_cnf_hankaku'] = 'パスワードは半角英数字でお願いします';
}

// 空白で「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (!isset($password_cnf))
{
    $err['password_required'] = 'パスワードは必須入力です。';
}

// 8～20文字の文字入力数でない場合に「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか

if (strlen($password_cnf) < 8 || strlen($password_cnf) > 20)
{
    $err['password_cnf_string_limit'] = 'パスワード確認の文字数は8文字以上20文字以下でお願いします。';
}

// 入力した文字が「パスワード」と一致しない場合にエラーが表示されるか

if ($password != $password_cnf)
{
    $err['password_match'] = 'パスワードが一致しません';
}

// --- email メールアドレス以外のテキストを入力し遷移するとエラーが表示されるか

// ２０１文字以上入力し「確認画面へ」のボタンで遷移すると登録フォームに戻りエラーが表示されるか
if (strlen($email) >= 201)
{
    
    $err['email_string_limit'] = '200文字以内に収めてください';
}

/**
 * メールアドレス登録時、既にDBに登録済みのアドレスの場合、エラーが表示されるか
 * あればtrueなければfalse
 * @var bool
 */
$hasEmail = $userLogic->checkSameDataExist('email', $email);

if ($hasEmail != false)
{
    $err['email_duplicate'] = '入力されたemailは既に使用されています';
}




// --------------------------------


if (count($err) > 0)
{

    $_SESSION = $err;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['sex'] = $sex;
    $_SESSION['prefecture'] = $prefecture;
    $_SESSION['other_address'] = $other_address;
    $_SESSION['email'] = $email;
    header('Location: member_regist.php');
    exit();
} else {
    $userLogic->createUser($_POST);
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
    <button type="button" onclick="history.back()">戻る</button>
</body>
</html>