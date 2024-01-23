<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="login/css/style.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>新規登録フォーム</title>
</head>

<body>
  <div class="login_wrapper">

    <h1>ちょうどいいタスク管理</h1>
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
      <p>すでに登録済みの方はこちら</p>
      <button><a href="login.php">ログイン</a></button>
    </div>

  </div>
</body>

</html>
