<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/login/css/style.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>ログインフォーム</title>
</head>

<body>
  <div class="login_wrapper">
    <img class="logo" src="./img/dev2logo.svg" width="200" height="66" alt="ちょうどいいタスク管理">
    <form action="authenticate.php" method="post">
      <div>
        <label for="email">メールアドレス</label><br>
        <input type="email" name="email" id="email" required>
      </div>
      <div>
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password" required>
      </div>
      <div>
        <input type="submit" value="ログイン">
      </div>
    </form>
    <div>
      <p class=login_p>未登録の方はこちら</p>
      <a href="signup.php" class="button_1">新規登録</a>
    </div>
  </div>
</body>

</html>
