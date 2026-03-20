<!-- 検索 -->
<form method="get" class="mb-3 d-flex gap-2">

<input name="keyword" class="form-control"
placeholder="検索"
value="<?= htmlspecialchars($_GET["keyword"] ?? "") ?>">

<select name="sort" class="form-select"
onchange="this.form.submit()">

<option value="created" <?= ($_GET["sort"] ?? "")==="created"?"selected":"" ?>>作成順</option>
<option value="deadline" <?= ($_GET["sort"] ?? "")==="deadline"?"selected":"" ?>>期限順</option>
<option value="priority" <?= ($_GET["sort"] ?? "")==="priority"?"selected":"" ?>>優先度</option>

</select>

</form>

<h5>タスク一覧</h5>

<?php foreach($tasks ?? [] as $task): ?>

<?php
$bg = "bg-white";

if(($task["status"] ?? "")==="done"){
    $bg = "bg-light text-muted";
}
elseif(!empty($task["end_date"]) &&
strtotime($task["end_date"]) < time()){
    $bg = "bg-danger-subtle";
}
?>

<div class="card mb-2 shadow-sm <?= $bg ?>">
<div class="card-body">

<div class="d-flex justify-content-between">
<strong><?= htmlspecialchars($task["title"] ?? "") ?></strong>

<?php
$statusMap = [
  "todo" => "未着手",
  "doing" => "進行中",
  "done" => "完了"
];

$statusClass = [
  "todo" => "bg-secondary",
  "doing" => "bg-warning",
  "done" => "bg-success"
];
?>

<span class="badge <?= $statusClass[$task["status"]] ?? "bg-secondary" ?>">
<?= $statusMap[$task["status"]] ?? $task["status"] ?>
</span>
</div>

<div class="small text-muted">
<?= htmlspecialchars($task["project_name"] ?? "") ?>
</div>

<div class="small mt-1">
<?= htmlspecialchars($task["description"] ?? "") ?>
</div>

<div class="small text-muted mt-1">
<?php if(!empty($task["start_date"]) && !empty($task["end_date"])): ?>
<?= date('Y/m/d', strtotime($task["start_date"])) ?>
 ~ 
<?= date('Y/m/d', strtotime($task["end_date"])) ?>
<?php endif; ?>
</div>

<div class="mt-2 d-flex justify-content-end gap-2">
<a href="index.php?action=edit&id=<?= $task["id"] ?>"
class="btn btn-sm btn-outline-primary">編集</a>

<a href="index.php?action=delete&id=<?= $task["id"] ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('削除しますか？')">削除</a>
</div>

</div>
</div>

<?php endforeach; ?>