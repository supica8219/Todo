<?php
// エラー表示
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);
// セッション開始とログインチェック
session_start();
if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}
// DB接続と関数の読み込み
require "db.php";
require "functions.php";
// アクションの取得
$action = $_GET["action"] ?? "list";

/* ===== アクション毎の処理 ===== */
if($_SERVER["REQUEST_METHOD"]==="POST"){

    if($action==="add_task"){
        addTask($pdo,$_SESSION["user_id"]);
    }
    elseif($action==="edit" && isset($_GET["id"])){
        updateTask($pdo,$_GET["id"]);
    }
    elseif($action==="add_project"){
        addProject($pdo,$_SESSION["user_id"]);
    }
    elseif($action==="add_user"){
        addUser($pdo);
    }
    header("Location:index.php");
    exit;
}
// タスク削除
if($action==="delete" && isset($_GET["id"])){
    deleteTask($pdo,$_GET["id"]);
    header("Location:index.php");
    exit;
}

/* ===== データ取得 ===== */
// タスク情報取得（タスク編集画面で使用）
if($action==="edit" && isset($_GET["id"])){
    $task = getTask($pdo,$_GET["id"]);
}
// プロジェクト一覧取得（タスク追加・編集画面で使用）
if($action==="add_task" || $action==="edit"){
    $projects = getProjects($pdo,$_SESSION["user_id"]);
}
// タスク一覧
if($action==="list"){
    $tasks = getTasks($pdo,$_SESSION["user_id"]);
}
// ユーザー情報
if($action==="user"){
    $stmt = $pdo->prepare("SELECT name,email FROM users WHERE id=?");
    $stmt->execute([$_SESSION["user_id"]]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="manifest" href="/CRUD/manifest.json">
<meta name="theme-color" content="#2f80ed">
<link rel="apple-touch-icon" href="/CRUD/icons/icon-192.png">
<link rel="icon" type="image/png" href="/CRUD/icons/icon-192.png">
<title>タスク管理</title>
</head>

<body class="bg-light">
<?php include "header.php"; ?>
<div class="container py-3">
<!-- ナビ -->
<div class="d-flex justify-content-between mb-3">
  <a href="index.php" class="btn btn-outline-secondary btn-sm">一覧</a>
  <div class="d-flex gap-2">
    <a href="index.php?action=add_task" class="btn btn-primary btn-sm">＋タスク</a>
    <a href="index.php?action=add_project" class="btn btn-success btn-sm">＋プロジェクト</a>
    <a href="index.php?action=user" class="btn btn-outline-dark btn-sm">ユーザー</a>
  </div>
</div>

<?php
//  ビューの読み込み
$view = "views/" . $action . ".php";
if(file_exists($view)){
    include $view;
} else {
    include "views/list.php";
}
?>
</div>
<!-- フッターの読み込み -->
<?php include "footer.php"; ?>
</body>
</html>