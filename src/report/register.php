<?php
session_start(); // セッションを開始

//データベース接続
$host = 'db'; // docker_composeで定義したDBサービス名をホストとして使用する
$dbname = 'chodoii_task';
$user = 'root';
$pass = 'pass';


$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

// POSTリクエストの場合のみ処理を行う
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // // デバッグ用コード
  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';
  // POSTデータを変数に格納
  $report_id = isset($_POST['report_id']) ? $_POST['report_id'] : null; // 日報のid 空の場合はnull
  $date = $_POST['date']; // カレンダーの日付
  $report = $_POST['text']; // 日報の内容

  // セッション変数を取得
  $user_id = $_SESSION['user_id']; // ユーザーID

  // 日報を登録
  if ($report_id) {
    // 日報IDのテキストを更新
    $stmt = $pdo->prepare("UPDATE reports SET text = :report WHERE id = :report_id");
    $stmt->bindParam(':report', $report, PDO::PARAM_STR);
    $stmt->bindParam(':report_id', $report_id, PDO::PARAM_INT);
    $stmt->execute();
  } else {
    // 日報IDがnullの時、新規登録。
    $stmt = $pdo->prepare("INSERT INTO reports (text, date, user_id) VALUES (:report, :date, :user_id)");
    $stmt->bindParam(':report', $report, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  header('Location: ../index.php');
  exit;
}
