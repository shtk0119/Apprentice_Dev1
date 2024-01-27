## 開発時に使用するファイル
* 間違えて変更するのを防ぐためcalendar, header 等、パーツの名前がついたフォルダを作っています。該当パーツのフォルダを使用してください。
* [フォルダ名].phpで編集すると、index.phpに反映され確認ができます。個別に[フォルダ名].phpをWEBで確認することもできます。
* CSSもindex.phpに反映されます
* フォルダ内は自由に追加・削除をしてください。例）jsフォルダの追加など

## 該当の名前のファイルがない時、新しくファイルを作りたい時
* 該当のパーツのファイルがない場合、新しくフォルダを作ってください
* 新しいフォルダは既存のフォルダのコピーだと楽です
* 新しいphpファイルはindex.phpに読み込みを追加することでindex.phpに反映されます

```
<div id="grid-container">
    <div id="task-management">
      <!-- タスク管理のコード -->
      <?php include 'task/task.php'; ?>
    </div>
<!-- 該当の場所に追加 -->
</div>
```

* CSSやjsファイルをindex.phpに反映するためにhead内にファイルを読み込ませてください

```
<head>
     <link rel="stylesheet" type="text/css" href="task/css/style.css">
     <!-- index.phpからみた相対パスを入れます-->
</head>
```

## index.phpのレイアウトや読み込みについて
* index.phpのレイアウトは仮の状態です。開発がすすむにつれ変更を行います。
* index.phpへのCSSの反映が想定通りにならない可能性があります。調整が必要なので見つけたらご一報をお願いいたします。
原因:一番下に読み込まれたCSSファイルが優先、important!による優先

## 使用ライブラリ
- **easytimer**  
[jsDelivr](https://www.jsdelivr.com/package/npm/easytimer)  
[Document](https://albert-gonzalez.github.io/easytimer.js)

- **Chart.js**
[jsDelivr](https://www.jsdelivr.com/package/npm/chart.js)
[Document](https://www.chartjs.org)