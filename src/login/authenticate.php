<?php
session_start(); // セッションを開始

//データベース接続
$host = 'db'; // docker_composeで定義したDBサービス名をホストとして使用する
$dbname = 'chodoii_task';
$user = 'root'; // docker_composeで定義
$pass = 'pass'; // docker_composeで定義

//データベースへの接続
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

// フォームからの入力を受け取る
$email = $_POST['email'];
$password = $_POST['password'];

// データベースでユーザーを検索するためのSQLステートメントを準備
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();


// ユーザーが存在するか確認
if ($stmt->rowCount() == 1) {
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // パスワードが一致するか確認
  if (password_verify($password, $user['pwd'])) {
    // パスワードが一致した場合、セッション変数を設定
    $_SESSION['username'] = $user['name'];    // ユーザーのIDを'username'に設定
    $_SESSION['user_id'] = $user['id'];   // ユーザーの名前を'user_id'に設定

    // get-session.phpにリダイレクト
    header('Location: get-session.php');
    exit;
  } else {
    // パスワードが一致しない場合のエラーメッセージ
    echo "パスワードが正しくありません。";
    echo '<a href="login.php">新規登録画面に戻る</a>';
  }
} else {
  // ユーザーが見つからない場合のエラーメッセージ
  echo "該当するユーザーが見つかりません。";
  echo '<a href="login.php">新規登録画面に戻る</a>';
}

// データベース接続を閉じる
$pdo = null;
