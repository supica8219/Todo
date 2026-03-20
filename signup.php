<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();
require "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    $password_confirm = $_POST["password_confirm"] ?? "";
    if ($name === "" || $email === "" || $password === "") {
        $error = "すべて入力してください";
    } elseif ($password !== $password_confirm) {
        $error = "パスワードが一致しません";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "このメールアドレスは既に登録されています";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                INSERT INTO users(name,email,password)
                VALUES (?,?,?)
            ");
            $stmt->execute([$name, $email, $hash]);
            $_SESSION["user_id"] = $pdo->lastInsertId();
            $_SESSION["user_name"] = $name;
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="apple-touch-icon" href="/icons/icon-192.png">
<link rel="icon" type="image/png" href="/icons/icon-192.png">
<title>新規登録</title>
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
<div class="container">
<div class="row justify-content-center">
<div class="col-11 col-sm-8 col-md-5">
<div class="card shadow-sm rounded-4">
<div class="card-body p-4">
<h4 class="text-center mb-4">新規登録</h4>
<?php if($error): ?>
<div class="alert alert-danger">
<?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
<form method="POST">
<div class="mb-3">
<label class="form-label">ユーザー名</label>
<input type="text" name="name" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">メールアドレス</label>
<input type="email" name="email" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">パスワード</label>
<input type="password" name="password" class="form-control" required>
</div>
<div class="mb-3">
<label class="form-label">パスワード確認</label>
<input type="password" name="password_confirm" class="form-control" required>
</div>
<button type="submit" class="btn btn-primary w-100">
登録する
</button>
</form>
<div class="text-center mt-3">
<a href="login.php">ログインはこちら</a>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>