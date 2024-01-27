<?php
  require_once 'php/db-connect.php';

  $date = $_POST["datetime-local"] ?? date("Y-m-d");
  // $userId = $_SESSION['user_id'];
  try {
    // $taskLogsResult = $pdo->query(
    //   "SELECT task_id FROM task_logs
    //    WHERE user_id = $userId AND date = '$date'");
    $taskLogsResult = $pdo->query(
      "SELECT task_id FROM task_logs
       WHERE user_id = 1 AND date = '$date'");
    $taskIds = $taskLogsResult->fetchAll(PDO::FETCH_COLUMN);

    // 取得したtask_idをIN句に含めてtime_reportsを取得
    $inClause = implode(',', $taskIds);
    $timeReportsResult = $pdo->query(
      "SELECT t.name, tr.avg_time FROM time_reports AS tr
       INNER JOIN tasks AS t ON tr.task_id = t.id
       WHERE tr.user_id = 1 AND tr.task_id IN ($inClause)
       ORDER BY avg_time DESC");
    $timeReports = $timeReportsResult->fetchAll(PDO::FETCH_ASSOC);

    // 学習時間TOP5の時間計算
    $topFiveTimeReports = array_slice($timeReports, 0, 5);
    for ($i=0; $i < count($topFiveTimeReports); $i++) {
      $seconds = strtotime($timeReports[$i]['avg_time']) - strtotime("00:00:00");
      $hours = round($seconds / 3600, 1);
      $topFiveTimeReports[$i]['avg_time'] = $hours;
      $topFiveAndOtherTimeReports[] = $topFiveTimeReports[$i];
    }

    // 学習時間TOP5以外をその他にまとめる
    if (count($timeReports) >= 5) {
      $otherTimeReports = array_slice($timeReports, 5);
      $topFiveAndOtherTimeReports[] = array('name' => 'その他', 'avg_time' => 0);
      for ($i=0; $i < count($otherTimeReports); $i++) {
        $seconds = strtotime($otherTimeReports[$i]['avg_time']) - strtotime("00:00:00");
        $hours = round($seconds / 3600, 1);
        $otherTimeReports[$i]['avg_time'] = $hours;
        $topFiveAndOtherTimeReports[array_key_last($topFiveAndOtherTimeReports)]['avg_time'] += $otherTimeReports[$i]['avg_time'];
        $topFiveAndOtherTimeReports[array_key_last($topFiveAndOtherTimeReports)][] = $otherTimeReports[$i];
      }
    }
  } catch (PDOException $error) {
    echo "データの取得に失敗しました。";
  }
?>

<canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const timeReports = <?php echo json_encode($topFiveAndOtherTimeReports); ?>;
</script>
<script src="/graph/js/graph.js"></script>