<?php

namespace task;

require_once __dir__ . "/validate.php";

use function task\isTaskRegisterd;

function createTask($tasks, $taskQuery, $userId, $date)
{
    $taskName = $_POST["task_name"];

    if (isTaskRegisterd($tasks) === false) {
        $taskQuery->createNewTask($taskName, $userId);
        $taskQuery->createTimeReports($taskName, $userId);
        $result = $taskQuery->createDailyTask($taskName, $userId, $date);
        return $result;
    } else {
        $result = $taskQuery->createDailyTask($taskName, $userId, $date);
        return $result;
    }
}

function editTask($taskQuery, $userId, $date)
{
    if (isset($_POST["update"])) {
        $result = $taskQuery->editTaskName($date, $userId);
        return $result;
    } else if (isset($_POST["delete"])) {
        $result = $taskQuery->deleteDailyTask($date, $userId);
        return $result;
    } else if (isset($_POST["delete_flag"])) {
        $result = $taskQuery->chengeDeleteFlag($date, $userId);
        return $result;
    } else {
        return;
    }
}
