<h5>タスク追加</h5>

<form method="post" class="mt-3">

<input name="title" class="form-control mb-2" placeholder="タイトル">

<textarea name="description" class="form-control mb-2"></textarea>
<select name="status" class="form-select mb-2">
<option value="todo">未着手</option>
<option value="doing">進行中</option>
<option value="done">完了</option>
</select>

<select name="priority" class="form-select mb-2">
<option value="high">高</option>
<option value="medium">中</option>
<option value="low">低</option>
</select>

<input type="text" id="start_date" name="start_date" class="form-control mb-2">
<input type="text" id="end_date" name="end_date" class="form-control mb-2">

<select name="project_id" class="form-select mb-3">
<?php foreach($projects ?? [] as $p): ?>
<option value="<?= $p["id"] ?>">
<?= htmlspecialchars($p["name"]) ?>
</option>
<?php endforeach; ?>
</select>
<div class="mb-3">
  <a href="index.php?action=add_project" class="small">
    ＋ プロジェクトを新規作成
  </a>
</div>
<button class="btn btn-primary w-100">保存</button>

</form>