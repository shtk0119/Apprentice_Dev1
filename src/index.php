<?php
session_start();

require_once __DIR__ . '/header/header.php';

\header\header();
?>

<main id="main">
  <!-- グラフ -->
  <div id="graph">
    <!-- グラフのコード -->
    <?php include 'graph/graph.php'; ?>
  </div>
  <!-- 実績 -->
  <div id="task">
    <!-- 実績のコード -->
    <?php include 'task/task.php'; ?>
  </div>
  <!-- タイマー管理 -->
  <div id="timer">
    <!-- タイマー管理のコード -->
    <?php include 'timer/timer.php'; ?>
  </div>
  <div id="report">
    <!-- タスク管理のコード -->
    <?php include 'report/report.php'; ?>
  </div>
</main>
</body>

</html>
