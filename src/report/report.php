<?php

namespace report;

require_once "./task/query.php";
require_once "calc-time.php";
require_once "exec-tasks.php";
require_once 'get-report.php'; // 日報の取得

use task\Query;
use function report\getDailyTotaltime;
use function report\getExecTask;

$userId = 1;
$date = $_POST["datetime-local"] ?? date("Y-m-d");
$reportQuery = new Query();
// 1日に実施したタスクの取得
$execTasks = getExecTask($reportQuery, $userId);
// 1日の総合勉強時間の取得
$dailyTotaltime = getDailyTotaltime($execTasks);

?>

<div class="report">
  <div class="report-header">
    <span class="report-header-title">
      Task List
    </span>
    <span class="report-header-totaltime">
      総学習時間: <?php echo $dailyTotaltime; ?>
    </span>
  </div>
  <div class="report-inner" method="POST">
    <ul class="report-ul">
      <?php foreach ($execTasks as $key => $execTask) : ?>
        <li class="report-li">
          <form class="report-task-form" method="POST">
            <input type="hidden" name="task-logs-id" value="<?php echo $execTask["task_logs_id"] ?>">
            <input type="hidden" name="task-id" value="<?php echo $execTask["task_id"] ?>">
            <input type="hidden" name="datetime-local" value="<?php echo $date ?>">
            <div class="report-li-top">
              <span class="rank">
                <?php echo $key + 1 ?>
              </span>
              <span class="task-name">
                <?php echo $execTask["name"] ?>
              </span>
            </div>
            <div class="report-li-bottom">
              <div class="report-li-bottom-inner">
                <div class="daily-time">
                  <label>時間:</label>
                  <input class="daily-time-input" name="edit-time" value="<?php echo $execTask["time"] ?>">
                </div>
              </div>
              <span class="totaltime">
                合計時間: <?php echo $execTask["total_time"] ?>
              </span>
            </div>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    <form class="report-description" action="report/register.php" method="post">
      <label for="report-textarea">
        今日の振り返り
      </label>
      <div class="report-description-inner">
        <!-- 日報ID:表示しない -->
        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
        <!-- カレンダーの日付:表示しない -->
        <input type="hidden" name="date" value="<?php echo $date; ?>">
        <!-- 日報の内容 -->
        <textarea name="text" id="report-textarea" cols="30" rows="10"><?= isset($report) ? htmlspecialchars($report, ENT_QUOTES, 'UTF-8') : '' ?></textarea>
        <div class="button-area">
          <button type="submit" name="register" id="register" class="report-register-button">保存</button>
          <button>投稿</button>
        </div>
      </div>
    </form>
  </div>
</div>