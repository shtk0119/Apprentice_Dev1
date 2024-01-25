<?php
  require_once 'php/db-connect.php';
  
  $date = $_POST["datetime-local"] ?? date("Y-m-d");
  try {
    // login機能完成後、user_idをsessionから取得して使用
    $taskLogsResult = $pdo->query("SELECT * FROM task_logs WHERE user_id = 1 AND date = '$date'");

    while ($row = $taskLogsResult->fetch(PDO::FETCH_ASSOC)) {
      $taskLogs[] = $row;
      $taskId = $row['task_id'];
      $task = $pdo->query("SELECT * FROM tasks WHERE id = $taskId");
      
      if ($task) {
        $tasks[] = $task->fetch(PDO::FETCH_ASSOC);
      }
    }
  } catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
  }
?>

<div class="timer">
  <select class="timer-task-select">
    <option hidden>タスクを選択</option>
    <?php foreach ($tasks as $task) : ?>
      <option value="<?php echo $task['name'] ?>"><?php echo $task['name'] ?></option>
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