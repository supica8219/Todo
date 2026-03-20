<?php

/* ================= プロジェクト ================= */

function getProjects($pdo,$user_id){

    $stmt=$pdo->prepare("
    SELECT * FROM projects
    WHERE user_id=?
    ORDER BY id DESC
    ");

    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/* ================= タスク一覧 ================= */

function getTasks($pdo,$user_id){

    $keyword = $_GET["keyword"] ?? "";
    $sort = $_GET["sort"] ?? "created";

    $sql="
    SELECT
    t.*,
    p.name AS project_name
    FROM tasks t
    LEFT JOIN projects p ON t.project_id=p.id
    WHERE t.user_id=?
    ";

    $params = [$user_id];

    /* 検索 */
    if($keyword !== ""){
        $sql .= " AND t.title LIKE ?";
        $params[] = "%".$keyword."%";
    }

    /* ソート */
    if($sort === "deadline"){
        $sql .= " ORDER BY t.end_date ASC";
    }
    elseif($sort === "priority"){
        $sql .= " ORDER BY FIELD(t.priority,'high','medium','low')";
    }
    else{
        $sql .= " ORDER BY t.created_at DESC";
    }

    $stmt=$pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/* ================= タスク単体 ================= */

function getTask($pdo,$id){

    $stmt=$pdo->prepare("SELECT * FROM tasks WHERE id=?");
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


/* ================= タスク追加 ================= */

function addTask($pdo,$user_id){
    $start_date = !empty($_POST["start_date"]) ? date('Y-m-d', strtotime($_POST["start_date"])) : null;
$end_date   = !empty($_POST["end_date"]) ? date('Y-m-d', strtotime($_POST["end_date"])) : null;
    $sql="
    INSERT INTO tasks
    (user_id,project_id,title,description,status,start_date,end_date,priority)
    VALUES (?,?,?,?,?,?,?,?)
    ";

    $stmt=$pdo->prepare($sql);

    $stmt->execute([
        $user_id,
        $_POST["project_id"] ?? null,
        $_POST["title"] ?? "",
        $_POST["description"] ?? "",
        $_POST["status"] ?? "todo",
        $start_date,
        $end_date,
        $_POST["priority"] ?? "medium"
    ]);
}


/* ================= タスク更新 ================= */

function updateTask($pdo,$id){

    $start_date = !empty($_POST["start_date"]) ? date('Y-m-d', strtotime($_POST["start_date"])) : null;
    $end_date   = !empty($_POST["end_date"]) ? date('Y-m-d', strtotime($_POST["end_date"])) : null;

    $sql="
    UPDATE tasks
    SET
    project_id=?,
    title=?,
    description=?,
    status=?,
    start_date=?,
    end_date=?,
    priority=?
    WHERE id=?
    ";

    $stmt=$pdo->prepare($sql);

    $stmt->execute([
        $_POST["project_id"] ?? null,
        $_POST["title"] ?? "",
        $_POST["description"] ?? "",
        $_POST["status"] ?? "todo",
        $start_date,
        $end_date,
        $_POST["priority"] ?? "medium",
        $id
    ]);
}


/* ================= タスク削除 ================= */

function deleteTask($pdo,$id){

    $stmt=$pdo->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->execute([$id]);
}


/* ================= プロジェクト追加 ================= */

function addProject($pdo,$user_id){

    $stmt=$pdo->prepare("
    INSERT INTO projects(user_id,name)
    VALUES (?,?)
    ");

    $stmt->execute([
        $user_id,
        $_POST["name"] ?? ""
    ]);
}


/* ================= ユーザー追加 ================= */

function addUser($pdo){

    $stmt=$pdo->prepare("
    INSERT INTO users(name,email,password)
    VALUES (?,?,?)
    ");

    $password=password_hash($_POST["password"] ?? "",PASSWORD_DEFAULT);

    $stmt->execute([
        $_POST["name"] ?? "",
        $_POST["email"] ?? "",
        $password
    ]);
}


/* ================= ★ ユーザー取得（追加） ================= */

function getUser($pdo,$user_id){

    $stmt=$pdo->prepare("
    SELECT id,name,email
    FROM users
    WHERE id=?
    ");

    $stmt->execute([$user_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}