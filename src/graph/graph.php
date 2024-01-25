<?php
  require_once 'php/db-connect.php';

  try {
    // 日付のその日にやるタスクのデータのみを抽出
    $timeReportsResult = $pdo->query("SELECT * FROM time_reports WHERE user_id = 1 ORDER BY avg_time DESC");

    while ($row = $timeReportsResult->fetch(PDO::FETCH_ASSOC)) {
      $taskId = $row['task_id'];
      $task = $pdo->query("SELECT * FROM tasks WHERE id = $taskId");
      $row['name'] = $task->fetch(PDO::FETCH_ASSOC)['name'];

      // 時間形式 変換 00:00:00 -> 0 (少数第一位)
      $seconds = strtotime($row['avg_time']) - strtotime("00:00:00");
      $hours = round($seconds / 3600, 1);
      $row['avg_time'] = $hours;
      $timeReports[] = $row;
    }
  } catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
  }
?>

<canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const timeReports = <?php echo json_encode($timeReports); ?>;
</script>
<script src="/graph/js/graph.js"></script>