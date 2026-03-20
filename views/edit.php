<h5>タスク編集</h5>

<form method="post" class="mt-3">

<input type="hidden" name="id" value="<?= $task["id"] ?>">

<input name="title" class="form-control mb-2"
value="<?= htmlspecialchars($task["title"] ?? "") ?>">

<textarea name="description" class="form-control mb-2"><?= htmlspecialchars($task["description"] ?? "") ?></textarea>

<select name="status" class="form-select mb-2">
<option value="todo" <?= ($task["status"] ?? "")==="todo"?"selected":"" ?>>未着手</option>
<option value="doing" <?= ($task["status"] ?? "")==="doing"?"selected":"" ?>>進行中</option>
<option value="done" <?= ($task["status"] ?? "")==="done"?"selected":"" ?>>完了</option>
</select>

<select name="priority" class="form-select mb-2">
<option value="high" <?= ($task["priority"] ?? "")==="high"?"selected":"" ?>>高</option>
<option value="medium" <?= ($task["priority"] ?? "")==="medium"?"selected":"" ?>>中</option>
<option value="low" <?= ($task["priority"] ?? "")==="low"?"selected":"" ?>>低</option>
</select>

<input type="text" id="start_date" name="start_date" class="form-control mb-2"
value="<?= !empty($task['start_date']) ? date('Y/m/d', strtotime($task['start_date'])) : '' ?>" placeholder="着手日">

<input type="text" id="end_date" name="end_date" class="form-control mb-2"
value="<?= !empty($task['end_date']) ? date('Y/m/d', strtotime($task['end_date'])) : '' ?>" placeholder="終了日">

<select name="project_id" class="form-select mb-3">
<?php foreach($projects ?? [] as $p): ?>
<option value="<?= $p["id"] ?>"
<?= $p["id"]==($task["project_id"] ?? 0)?"selected":"" ?>>
<?= htmlspecialchars($p["name"]) ?>
</option>
<?php endforeach; ?>
</select>

<button class="btn btn-primary w-100">更新</button>

</form>