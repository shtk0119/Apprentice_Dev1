<?php
//register.phpからの処理
session_start(); // セッションを開始
echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; // セッション変数からユーザー名を返す
// index.phpでユーザー名を取得する処理を行う
