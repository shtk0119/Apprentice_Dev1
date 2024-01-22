<?php
  try {
    $pdo = new PDO('mysql:host=db;dbname=chodoii_task;', 'root', 'pass');
    $dailyTasks = $pdo->query("SELECT * FROM daily_tasks");

    if ($dailyTasks) {
      foreach ($dailyTasks as $dailyTask) {
        $taskId = $dailyTask['task_id'];
        $task = $pdo->query("SELECT * FROM tasks WHERE id = $taskId");
        // カレンダーの日付によって取得するログを変更できるようにする
        $taskLog = $pdo->query("SELECT * FROM task_logs WHERE task_id = $taskId AND DATE(created_at) = CURDATE()");
        
        if ($task) {
          $tasks[] = $task->fetch(PDO::FETCH_ASSOC);
        }

        if ($taskLog) {
          $taskLogs[] = $taskLog->fetch(PDO::FETCH_ASSOC);
        }
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