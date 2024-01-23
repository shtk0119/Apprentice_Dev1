<?php
//データベース接続
$host = 'db'; // docker_composeで定義したDBサービス名をホストとして使用する
$dbname = 'chodoii_task';
$user = 'root'; // docker_composeで定義
$pass = 'pass'; // docker_composeで定義

//データベースへの接続
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

//フォームが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  //ユーザー名のチェック
  if (empty($_POST["username"])) {
    echo "ユーザー名が未入力です。";
  } else {
    // ユーザー名が既に存在するかチェック
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :username");
    $stmt->bindValue(':username', $_POST["username"], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo "このユーザー名は既に使用されています。";
    }
  }

  //メールアドレスのチェック
  if (empty($_POST["email"])) {
    echo "メールアドレスが未入力です。";
  } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "メールアドレスの形式が正しくありません。";
  } else {
    // メールアドレスが既に存在するかチェック
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo "このメールアドレスは既に使用されています。";
    }
  }

  //パスワードのチェック
  if (empty($_POST["password"])) {
    echo "パスワードが未入力です。";
  }
  $stmt->bindValue(':pwd', $_POST["password"], PDO::PARAM_STR); //プレースホルダーの作成

  //エラーがなければ登録処理
  if (!empty($_POST["username"]) && !empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) && !empty($_POST["password"])) {
    //登録処理
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, pwd, name, created_at) VALUES (:email, :pwd, :username, now())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':pwd', $password, PDO::PARAM_STR);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // ユーザー名をセッション変数に保存　セッションストレージに保存する用
    session_start(); // セッションを開始
    $_SESSION['username'] = $_POST['username']; // ユーザー名をセッション変数に保存
    // get-session.phpでセッション変数からユーザー名を返す
    // get-session.phpで返されたユーザ名をindex.phpにて受取る処理を行う


    // ユーザーを別のページにリダイレクト
    header('Location: ../index.php');
    exit;
  }
}
