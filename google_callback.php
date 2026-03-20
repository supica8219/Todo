<?php
session_start();
require 'vendor/autoload.php';
require 'db.php';
require 'env.php';
// Googleクライアントの設定
$client = new Google_Client();
$client->setClientId(retClientId());
$client->setClientSecret(retClientSecret());
$client->setRedirectUri('https://portfolio.shizusouth.jp/CRUD/google_callback.php');
// 認証コード取得
if (!isset($_GET['code'])) {
    exit('認証失敗');
}
// アクセストークンの取得
$client->authenticate($_GET['code']);
$token = $client->getAccessToken();
$client->setAccessToken($token);
// ユーザー情報取得
$oauth = new Google_Service_Oauth2($client);
$user = $oauth->userinfo->get();
$email = $user->email;
$name = $user->name;
$google_id = $user->id;
// DB確認
$stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
$stmt->execute([$google_id]);
$userData = $stmt->fetch();
// 既存ユーザーがいない場合は新規登録
if (!$userData) {
    // emailで既存チェック()
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();
    if ($existingUser) {
        // 既存ユーザーとGoogle IDを紐付け
        $stmt = $pdo->prepare("UPDATE users SET google_id = ? WHERE email = ?");
        $stmt->execute([$google_id, $email]);
        $user_id = $existingUser['id'];
    } else {
        // 新規登録
        $stmt = $pdo->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $google_id]);
        $user_id = $pdo->lastInsertId();
    }
} else {
    $user_id = $userData['id'];
}
// ログイン状態
$_SESSION['user_id'] = $user_id;
header("Location: index.php");
exit;