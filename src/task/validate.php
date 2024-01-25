<?php
namespace task;

function isTaskRegisterd($tasks)
{
  $inputTask = $_POST["task_name"];
  $result = array_search($inputTask, array_column($tasks, 'name'));
  return $result;
}
?>