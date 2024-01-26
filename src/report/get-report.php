<?php

$user_id = $_SESSION['user_id']; // 'user_id'をセッション変数として設定

//データベース接続
$host = 'db'; // docker_composeで定義したDBサービス名をホストとして使用する
$dbname = 'chodoii_task';
$user = 'root'; // docker_composeで定義
$pass = 'pass'; // docker_composeで定義

//データベースへの接続
$dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

// 日付をカレンダーから取得
$date = $_POST["datetime-local"] ?? date("Y-m-d");

// 変数：reportsテーブルから日付に紐づくデータを取得　
$stmt = $dbh->prepare("SELECT id, text, date FROM reports WHERE date = :date");
$stmt->bindParam(':date', $date); // パラメータに値をバインド
$stmt->execute();

// 結果を取得：連想配列　キー:カラム名 値:データ
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// $result（連想配列）から値を取得
if ($result !== false && isset($result['text'])) {
  $report = $result['text'];
} else {
  $report = '';
}

if ($result !== false && isset($result['id'])) {
  $report_id = $result['id'];
} else {
  $report_id = '';
}
