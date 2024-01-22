<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taskId = $_POST['taskId'];
    $newTime = $_POST['newTime'];

    try {
      $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');
       // カレンダーの日付によって取得するログを変更できるようにする
      $stmt = $pdo->prepare("UPDATE task_logs SET time = :newTime WHERE task_id = :taskId AND DATE(created_at) = CURDATE()");
      $stmt->bindParam(':newTime', $newTime, PDO::PARAM_STR);
      $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
      $stmt->execute();

      echo '時間が正常に更新されました';
    } catch (PDOException $error) {
      echo 'エラー: ' . $error->getMessage();
    }
  }
?>