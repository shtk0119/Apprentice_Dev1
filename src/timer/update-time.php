<?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $newTime = $_POST['newTime'];
    $taskId = $_POST['taskId'];
    $userId = $_POST['userId'];

    try {
      $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');

      $stmt = $pdo->prepare(
        "UPDATE task_logs
         SET time = :newTime
         WHERE id = :id");
      $stmt->bindParam(':newTime', $newTime, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      $stmt = $pdo->prepare(
        "UPDATE time_reports
         SET total_time = (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(time))) FROM task_logs WHERE task_id = :taskId AND user_id = :userId),
             avg_time = (SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(time))) FROM task_logs WHERE task_id = :taskId AND user_id = :userId)
         WHERE task_id = :taskId AND user_id = :userId");
      $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
      $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
      $stmt->execute();

      echo '時間が正常に更新されました';
    } catch (PDOException $error) {
      echo 'エラー: ' . $error->getMessage();
    }
  }
?>