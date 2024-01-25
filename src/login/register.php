<?php
session_start(); // セッションを開始

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
    echo '<a href="signup.php">新規登録画面に戻る</a>';
    return; // ここで処理を終了
  } else {
    // ユーザー名が既に存在するかチェック
    $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :username");
    $stmt->bindValue(':username', $_POST["username"], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo "このユーザー名は既に使用されています。";
      echo '<a href="signup.php">新規登録画面に戻る</a>';
      return; // ここで処理を終了
    }
  }

  //メールアドレスのチェック
  if (empty($_POST["email"])) {
    echo "メールアドレスが未入力です。";
    echo '<a href="signup.php">新規登録画面に戻る</a>';
    return; // ここで処理を終了
  } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "メールアドレスの形式が正しくありません。";
    echo '<a href="signup.php">新規登録画面に戻る</a>';
    return; // ここで処理を終了
  } else {
    // メールアドレスが既に存在するかチェック
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      echo "このメールアドレスは既に使用されています。";
      echo '<a href="signup.php">新規登録画面に戻る</a>';
      return; // ここで処理を終了
    }
  }

  //パスワードのチェック
  if (empty($_POST["password"])) {
    echo "パスワードが未入力です。";
    echo '<a href="signup.php">新規登録画面に戻る</a>';
    return; // ここで処理を終了
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

    // 新しく作成されたユーザーIDの取得
    $userId = $pdo->lastInsertId();

    // ユーザー名とユーザーIDをセッション変数に保存
    $_SESSION['username'] = $_POST['username']; // ユーザー名
    $_SESSION['user_id'] = $userId; // ユーザーID

    // セッションデータをすぐに保存
    session_write_close();

    // ユーザーを別のページにリダイレクト
    header('Location: get-session.php');
    exit;
  }
}

// データベース接続を閉じる
$pdo = null;
