<?php

namespace header;

function header()
{
  $date = $_POST["datetime-local"] ?? date("Y-m-d");
?>
  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="./header/css/header.css">
    <link rel="stylesheet" type="text/css" href="graph/css/style.css">
    <link rel="stylesheet" type="text/css" href="report/css/style.css">
    <link rel="stylesheet" type="text/css" href="task/css/style.css">
    <link rel="stylesheet" type="text/css" href="timer/css/style.css">
    <title>ちょうどいいタスク管理アプリ</title>

    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js" defer></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/en.js" defer></script>
    <script src="./header/js/header.js" type="module" defer></script>
  </head>

  <body id="grid-container">

    <header class="header">
      <div class="header-logo">
        <img src="./header/images/dev2logo.svg" alt="header-image">
      </div>
      <form class="cal-container" action="index.php" method="POST">
          <input class="cal" id="myCal" type="text" name="datetime-local">
          <span class="cal-date"><?php echo $date?></span>
      </form>
      <div class="header-username">
        <span class="header-username-span"></span>
      </div>
      <div class="header-humburger">
        <span class="header-humburger-top"></span>
        <span class="header-humburger-bottom"></span>
      </div>
      <nav class="header-nav">
        <span class="header-nav-config">
          設定
        </span>
        <span class="header-nav-logout">
          ログアウト
        </span>
      </nav>
    </header>

  <?PHP
} ?>