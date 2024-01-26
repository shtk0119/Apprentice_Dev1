<?php

namespace task;

require_once __DIR__ . "/query.php";
require_once __DIR__ . "/validate.php";
require_once __DIR__ . "/task.clud.php";

$taskQuery = new Query();
$userId = 1;
$date = $_POST["datetime-local"] ?? date("Y-m-d");
$tasks = $taskQuery->tasks($userId);
$dailyTasks = $taskQuery->dailyTasks($date, $userId);
$dailyTasks = editTask($taskQuery, $userId, $date);

if (!empty($_POST["task_name"])) {
  $dailyTasks = createTask($tasks, $taskQuery, $userId, $date);
}

?>
<div class="task">
  <form class="task-add" method="POST">
    <input class="task-add-edit" type="text" list="task-list" name="task_name" />
    <input type="hidden" name="datetime-local" value="<?php echo $date ?>">
    <datalist id="task-list">
      <?php foreach ($tasks as $task) : ?>
        <option value="<?php echo $task["name"]; ?>">平均時間 <?php echo $task["avg_time"] ?></option>
      <?php endforeach; ?>
    </datalist>
    <button class="task-add-submit" type="submit">+</button>
  </form>

  <div class="tasks">
    <ul class="tasks-ul">
      <?php foreach ($dailyTasks as $key => $dailyTask) : ?>
        <li class="tasks-li">
          <form class="tasks-form" method="POST">
            <button class="tasks-item-complete <?php echo $dailyTask["delete_flag"] === 1 ? 'completed' : ''; ?>" type="submit" name="delete_flag" value="<?php echo $dailyTask["delete_flag"] ?>">
              <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" width="24" height="24" color="#000000">
                <path class="tasks-item-complete-icon" d="M12,22.5h0A11.87,11.87,0,0,1,2.45,10.86V3.41L12,1.5l9.55,1.91v7.45A11.87,11.87,0,0,1,12,22.5Z"></path>
                <polyline class="tasks-item-complete-icon" points="7.23 10.93 10.81 14.51 16.77 8.54"></polyline>
              </svg>
            </button>
            <div class="tasks-item <?php echo $dailyTask["delete_flag"] === 1 ? 'completed' : ''; ?>">
              <input type="hidden" name="datetime-local" value="<?php echo $date ?>">
              <input type="hidden" name="task-logs-id" value="<?php echo $dailyTask["id"] ?>">
              <input type="hidden" name="key" value="<?php echo $key ?>">
              <div class="tasks-item-inner">
                <input class="tasks-item-input" type="text" name="editName" value="<?php echo $dailyTask["name"] ?>">
                <input type="hidden" name="">
                <button class="tasks-item-cancel" type="submit" name="update">
                  <svg id="_2" data-name="2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 511.98">
                    <polygon class="cls-1" points="326.25 147.82 256 218.07 185.75 147.82 147.82 185.74 218.07 255.99 147.82 326.24 185.75 364.17 256 293.92 326.26 364.17 364.19 326.24 293.93 255.99 364.19 185.73 326.25 147.82" />
                    <path class="cls-1" d="M437.02,74.98C390.76,28.69,326.62-.02,256,0,185.38-.02,121.24,28.69,74.98,74.98,28.7,121.22,0,185.38,0,255.99c0,70.61,28.7,134.76,74.98,181.01,46.26,46.29,110.4,75,181.02,74.98,70.62.02,134.76-28.69,181.02-74.98,46.28-46.25,74.99-110.39,74.98-181.01.02-70.62-28.7-134.77-74.98-181.01ZM405.07,405.06c-38.22,38.18-90.77,61.74-149.07,61.74s-110.85-23.56-149.07-61.74c-38.18-38.23-61.73-90.79-61.75-149.07.02-58.28,23.57-110.85,61.75-149.07,38.22-38.19,90.78-61.74,149.07-61.74s110.85,23.55,149.07,61.74c38.18,38.22,61.74,90.79,61.75,149.07,0,58.28-23.57,110.84-61.75,149.07Z" />
                  </svg>
                </button>
              </div>
              <span class="tasks-item-time">
                Avg time | <?php echo $dailyTask["avg_time"] ?>
              </span>
            </div>
            <div class="tasks-edit">
              <button class="tasks-edit-rename" type="submit" name="update">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8787 1.70705C14.0503 0.535477 15.9497 0.535475 17.1213 1.70705L19.2929 3.87862C20.4645 5.0502 20.4645 6.94969 19.2929 8.12126L11.7071 15.707C11.5196 15.8946 11.2652 15.9999 11 15.9999H6C5.44772 15.9999 5 15.5522 5 14.9999V9.99994C5 9.73473 5.10536 9.48037 5.29289 9.29284L12.8787 1.70705ZM15.7071 3.12126C15.3166 2.73074 14.6834 2.73074 14.2929 3.12126L13.4142 3.99994L17 7.58573L17.8787 6.70705C18.2692 6.31652 18.2692 5.68336 17.8787 5.29284L15.7071 3.12126ZM15.5858 8.99994L12 5.41416L7 10.4142V13.9999H10.5858L15.5858 8.99994ZM5 2.99994C3.34315 2.99994 2 4.34309 2 5.99994V15.9999C2 17.6568 3.34315 18.9999 5 18.9999H15C16.6569 18.9999 18 17.6568 18 15.9999V12.9999C18 12.4477 18.4477 11.9999 19 11.9999C19.5523 11.9999 20 12.4477 20 12.9999V15.9999C20 18.7614 17.7614 20.9999 15 20.9999H5C2.23858 20.9999 0 18.7614 0 15.9999V5.99994C0 3.23852 2.23858 0.999942 5 0.999942H8C8.55228 0.999942 9 1.44766 9 1.99994C9 2.55223 8.55228 2.99994 8 2.99994H5Z" fill="#9E9E9E" />
                </svg>
              </button>
              <button class="tasks-edit-trush" type="submit" name="delete">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <ellipse cx="12" cy="7" rx="7" ry="3" stroke="#9E9E9E" stroke-width="2" stroke-linecap="round" />
                  <path d="M7 18L5 7L8 10H16L19 7L17 18L14 20H10L7 18Z" fill="#9E9E9E" />
                  <path d="M5 7L6.99621 17.9792C6.99868 17.9927 7.00522 18.0052 7.01497 18.015V18.015C9.76813 20.7681 14.2319 20.7681 16.985 18.015V18.015C16.9948 18.0052 17.0013 17.9927 17.0038 17.9792L19 7" stroke="#9E9E9E" stroke-width="2" stroke-linecap="round" />
                </svg>
              </button>
            </div>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>