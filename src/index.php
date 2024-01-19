<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="header/css/style.css">
  <link rel="stylesheet" type="text/css" href="calender/css/style.css">
  <link rel="stylesheet" type="text/css" href="graph/css/style.css">
  <link rel="stylesheet" type="text/css" href="report/css/style.css">
  <link rel="stylesheet" type="text/css" href="task/css/style.css">
  <title>ちょうどいいタスク管理アプリ</title>
</head>

<body>
  <div id="grid-container">
    <!-- ヘッダーナビゲーション -->
    <div id="header">
      <?php include 'header/header.php'; ?>
    </div>
    <!-- グラフ -->
    <div id="graph">
      <!-- グラフのコード -->
      <?php include 'graph/graph.php'; ?>
    </div>
    <!-- カレンダー・タイマー -->
    <div id="calendar">
      <?php include 'calendar/calendar.php'; ?>
    </div>
    <!-- 実績 -->
    <div id="report">
      <!-- 実績のコード -->
      <?php include 'report/report.php'; ?>
    </div>
    <!-- タスク管理 -->
    <div id="task-management">
      <!-- タスク管理のコード -->
      <?php include 'task/task.php'; ?>
    </div>


  </div>
</body>

</html>
