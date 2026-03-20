<?php
// ログイン処理
session_start();
require "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // 入力値の取得
  $email = $_POST["email"];
  $password = $_POST["password"];
  // ユーザーの取得
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  // パスワードの検証
  if ($user && password_verify($password, $user["password"])) {
    // ログイン成功
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["user_name"] = $user["name"];
    header("Location: index.php");
    exit;
} else {
  // ログイン失敗
  $error = "メールまたはパスワードが違います";
}
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>ログイン</title>
</head>

<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
<div class="row justify-content-center">
<div class="col-11 col-sm-8 col-md-5">
<div class="card shadow-sm rounded-4">
<div class="card-body p-4">
<h4 class="text-center mb-4">ログイン</h4>
<!-- エラーメッセージ -->
<?php if($error): ?>
<div class="alert alert-danger">
<?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
<!-- ログインフォーム -->
<form method="POST">
  <div class="mb-3">
    <label class="form-label">メールアドレス</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">パスワード</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-primary w-100 mb-3">ログイン</button>
</form>
<!-- 区切り線 -->
<div class="text-center my-3">
  <span class="text-muted">または</span>
</div>
<!-- Googleログインボタン-->
<a href="google_login.php" class="btn btn-outline-danger w-100">
  Googleでログイン
</a>
<!-- 新規登録-->
<div class="text-center mt-3">
  <small class="text-muted">
    アカウントをお持ちでない方は<br>
    <a href="signup.php">新規登録</a>
  </small>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>