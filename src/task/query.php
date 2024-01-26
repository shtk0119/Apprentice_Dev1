<?php

namespace task;

use PDO;
use PDOException;

class Query
{
  private $host = "db";
  private $dbName = "chodoii_task";
  private $user = "root";
  private $pwd = "pass";
  private $port = "3306";
  private $conn;

  function __construct()
  {
    try {
      $dsn = "mysql:host={$this->host};dbname={$this->dbName};port={$this->port}";
      $this->conn = new PDO($dsn, $this->user, $this->pwd);
    } catch (PDOException $e) {
      echo "エラー！" . $e->getMessage();
    }
  }

  // 問題なし
  function tasks($userId)
  {
    $query = '
      SELECT t.name, tr.avg_time FROM tasks t
      INNER JOIN time_reports tr
      ON t.id = tr.task_id
      WHERE t.user_id = :user_id;';
    $stmt = $this->conn->prepare($query);
    try {
      $pst = $stmt->execute(
        [
          ':user_id' => $userId
        ]
      );
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo "ごめんなさい、タスクが取れませんでした！" . PHP_EOL;
    }
  }

  // 問題なし　３つのテーブル結合からの日別データのため名称継続
  function dailyTasks($date, $userId)
  {
    $query = '
      SELECT t.name, tr.avg_time, tl.id, tl.delete_flag  FROM task_logs tl
      INNER JOIN tasks t
      ON tl.task_id = t.id
      INNER JOIN time_reports tr
      ON tl.task_id = tr.task_id
      WHERE tl.date = :date and tl.user_id = :user_id;';
    try {
      $stmt = $this->conn->prepare($query);
      $pst = $stmt->execute(
        [
          ':date' => $date,
          ':user_id' => $userId
        ]
      );
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo "今日の予定が見つかりませんでした！" . PHP_EOL;
    }
  }

  // 問題なし
  function createNewTask($taskName, $userId)
  {
    $query = '
    INSERT INTO tasks (`name`, `user_id`)
    VALUES (
      :task_name, :user_id);';
    $stmt = $this->conn->prepare($query);
    try {
      $stmt->execute(
        [
          ':task_name' => $taskName,
          ':user_id' => $userId
        ]
      );
    } catch (PDOException $e) {
      echo "新しいタスクの登録に失敗しました。再度タスクを登録してください" . PHP_EOL;
    }
  }

  // 問題なし
  function createTimeReports($taskName, $userId)
  {
    $query = '
      INSERT INTO time_reports (`task_id`,`user_id`)
      VALUES(
        (SELECT id FROM tasks WHERE name = :task_name
        AND user_id = :user_id),
        :user_id
      );
    ';
    $stmt = $this->conn->prepare($query);
    try {
      $stmt->execute([
        ':task_name' => $taskName,
        ':user_id' => $userId
      ]);
    } catch (PDOException $e) {
      echo "タスク作成に失敗しました。再度タスクの登録をしてください！" . PHP_EOL;
    }
  }

  // 問題なし
  function createDailyTask($taskName, $userId, $date)
  {
    $query = '
      INSERT INTO task_logs (`date`, `task_id`, `user_id`)
      VALUES (
      :add_date,
      (SELECT `id` from `tasks` WHERE `name` = :task_name and `user_id` = :user_id),
      :user_id)
      ';
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute(
        [
          ':add_date' => $date,
          ':task_name' => $taskName,
          ':user_id' => $userId
        ]
      );
    } catch (PDOException $e) {
      echo "タスクの登録に失敗しました。再度お試しください。" . PHP_EOL;
    }

    $result = $this->dailyTasks($date, $userId);
    return $result;
  }

  function deleteDailyTask($date, $userId)
  {
    $taskLogsId = $_POST["task-logs-id"];

    $query = '
      DELETE FROM task_logs
      WHERE date = :date
      AND user_id = :user_id
      AND id = :task_logs_id;
      ';
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute(
        [
          ':date' => $date,
          ':user_id' => $userId,
          ':task_logs_id' => $taskLogsId
        ]
      );
    } catch (PDOException $e) {
      echo "今日の予定だったタスクの削除ができませんでした。再度お試しください。" . PHP_EOL;
    }

    $result = $this->dailyTasks($date, $userId);
    return $result;
  }

  function editTaskName($date, $userId)
  {
    $task_logs_id = $_POST["task-logs-id"];
    $editName = $_POST["editName"];
    $query = '
        UPDATE tasks
        SET name = :name
        WHERE id = (SELECT task_id FROM task_logs WHERE id = :task_logs_id);
    ';
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute(
        [
          ':name' => $editName,
          ':task_logs_id' => $task_logs_id
        ]
      );
    } catch (PDOException $e) {
      echo "タスク名の変更ができませんでした。再度お試しください。" . PHP_EOL;
    }

    $result = $this->dailyTasks($date, $userId);
    return $result;
  }

  function chengeDeleteFlag($date, $userId)
  {
    $deleteFlag = $_POST["delete_flag"];
    $task_logs_id = $_POST["task-logs-id"];
    $query = '
        UPDATE task_logs
        SET delete_flag = :delete_flag
        WHERE id = :task_logs_id
    ';
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute(
        [
          ':delete_flag' => $deleteFlag,
          ':task_logs_id' => $task_logs_id
        ]
      );
    } catch (PDOException $e) {
      echo "完了進捗が登録できませんでした。" . PHP_EOL;
    }

    $result = $this->dailyTasks($date, $userId);
    return $result;
  }

  // ここから下は、実績コンポーネントで使用するメソッド
  // 理想は、このクラスを抽象化してtask管理用とreport管理用クラスに切り分けたい

  function getExecTask($userId)
  {
    $date = $_POST["datetime-local"] ?? date("Y-m-d");
    $query = '
      SELECT tl.time, t.name, tr.total_time, tl.id FROM task_logs tl
      INNER JOIN tasks t
      ON tl.task_id = t.id
      INNER JOIN time_reports tr
      ON tl.task_id = tr.task_id
      WHERE tl.date = :date
      AND tl.user_id = :user_id
      ORDER BY tl.time DESC;
      ';
    try {
      $stmt = $this->conn->prepare($query);
      $pst = $stmt->execute(
        [
          ':date' => $date,
          ':user_id' => $userId
        ]
      );
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $execTasks = array_filter($results, function ($result) {
        return $result["time"] !== "00:00:00";
      });
      return $execTasks;
    } catch (PDOException $e) {
      echo "今日の実績が見つかりませんでした！" . PHP_EOL;
    }
  }

  function editTime($editTime, $taskLogsId, $userId)
  {
    $query = '
      UPDATE task_logs
      SET time = :edit_time
      WHERE id = :task_logs_id
    ';
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute(
        [
          ':edit_time' => $editTime,
          ':task_logs_id' => $taskLogsId
        ]
      );
    } catch (PDOException $e) {
      echo "時間の編集登録ができませんでした。" . PHP_EOL;
    }

    $execTasks = $this->getExecTask($userId);
    return $execTasks;
  }
}
