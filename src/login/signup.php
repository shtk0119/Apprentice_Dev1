<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>新規登録フォーム</title>
</head>

<body>
  <div class="login_wrapper">

    <img class="logo" src="./img/dev2logo.svg" width="200" height="66" alt="ちょうどいいタスク管理">
    <form action="register.php" method="post">
      <div>
        <label for="username">ユーザー名</label><br>
        <input type="text" name="username" id="username" required>
      </div>
      <div>
        <label for="email">メールアドレス</label><br>
        <input type="email" name="email" id="email" required>
      </div>
      <div>
        <label for="password">パスワード</label><br>
        <input type="password" name="password" id="password" required>
      </div>
      <div>
        <input type="submit" value="新規登録">
      </div>
    </form>
    <div>
      <p class=login_p>すでに登録済みの方はこちら</p>
      <a href="login.php" class="button_1">ログイン</a>
    </div>
  </div>
</body>

</html>
