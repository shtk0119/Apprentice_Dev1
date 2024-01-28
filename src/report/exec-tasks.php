<?php

namespace report;

use Exception;

function getExecTask($reportQuery, $userId)
{
    if (isset($_POST["edit-time"])) {
        $editTime = $_POST["edit-time"];
        $taskLogsId = $_POST["task-logs-id"];
        $taskId = $_POST["task-id"];
        if (isTimeType($editTime)) {
            $execTasks = $reportQuery->editTime($editTime, $taskLogsId, $userId, $taskId);
            return $execTasks;
        } else {
            $execTasks = $reportQuery->getExecTask($userId);
            return $execTasks;
        }
    } else {
        $execTasks = $reportQuery->getExecTask($userId);
        return $execTasks;
    }
}

function isTimeType($time)
{
    $pattern = '/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/';
    try{
        if (preg_match($pattern, $time)) {
            return true;
        } else {
            throw new Exception('時間の入力は00:00:00 ~ 23:59:59で入力してください。');
            return false;
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
}