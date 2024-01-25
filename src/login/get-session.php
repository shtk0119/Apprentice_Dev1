<?php
// セッションを開始ユーザーネームのセッション変数取得用テストコード
session_start();
?>

<!-- ユーザー変数取得用！消さない！ -->
<span class="header-username-span-data" data-username="<?php echo htmlspecialchars($_SESSION['username'] ?? 'default', ENT_QUOTES, 'UTF-8'); ?>" data-userid="<?php echo htmlspecialchars($_SESSION['user_id'] ?? 'default', ENT_QUOTES, 'UTF-8'); ?>"></span>

<!-- ページが読み込まれたあと→ユーザー変数をセッションストレージに保存 -->
<script>
  window.onload = function() {
    var usernameSpan = document.querySelector('.header-username-span-data');
    var username = usernameSpan.getAttribute('data-username');
    var userId = usernameSpan.getAttribute('data-userid');
    sessionStorage.setItem('name', username); // キーnameでユーザー名を保存
    sessionStorage.setItem('user_id', userId); // キーuser_idでユーザーidを保存


    // JavaScriptでリダイレクト
    window.location.href = '../index.php';
  };
</script>
