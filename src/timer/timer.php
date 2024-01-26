<?php
  $date = $_POST["datetime-local"] ?? date("Y-m-d");
  // $userId = $_SESSION['user_id'];
  
  try {
    $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');

    // $taskLogsResult = $pdo->query(
    //   "SELECT tl.id, t.name, tl.time, tl.date, tl.user_id, tl.task_id FROM task_logs AS tl
    //    INNER JOIN tasks AS t ON tl.task_id = t.id
    //    WHERE tl.user_id = $userId AND tl.date = '$date'");

    $taskLogsResult = $pdo->query(
      "SELECT tl.id, t.name, tl.time, tl.date, tl.user_id, tl.task_id FROM task_logs AS tl
       INNER JOIN tasks AS t ON tl.task_id = t.id
       WHERE tl.user_id = 1 AND tl.date = '$date'");
    $taskLogs = $taskLogsResult->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $error) {
    echo "データの取得に失敗しました。";
  }
?>

<div class="timer">
  <select class="timer-task-select">
    <option hidden>タスクを選択</option>
    <?php foreach ($taskLogs as $taskLog) : ?>
      <option value="<?php echo $taskLog['name'] ?>"><?php echo $taskLog['name'] ?></option>
    <?php endforeach; ?>
  </select>

  <div class="timer-display">
    <div id="time" class="timer-display-time">
      00:00:00
    </div>
    <button id="timer-button" class="timer-display-button">
      <img src="/timer/images/Play_icon.svg">
      <img class="clear" src="/timer/images/Stop_fill.svg">
    </button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/easytimer@1.1.3/dist/easytimer.min.js"></script>
<script>
  const taskLogs = <?php echo json_encode($taskLogs); ?>;
</script>
<script src="/timer/js/timer.js"></script>