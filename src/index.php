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

<body id="grid-container">
  <!-- ヘッダーナビゲーション -->
  <header id="header">
    <?php include 'header/header.php'; ?>
  </header>
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