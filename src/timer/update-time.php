<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $newTime = $_POST['newTime'];

    try {
      $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');

      $stmt = $pdo->prepare("UPDATE task_logs SET time = :newTime WHERE id = :id");
      $stmt->bindParam(':newTime', $newTime, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      echo '時間が正常に更新されました';
    } catch (PDOException $error) {
      echo 'エラー: ' . $error->getMessage();
    }
  }
?>