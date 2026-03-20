<h5 class="mb-3">ユーザー情報</h5>

<div class="card shadow-sm rounded-3">
  <div class="card-body">

    <div class="mb-3">
      <div class="text-muted small">ユーザー名</div>
      <div class="fw-bold"><?= htmlspecialchars($currentUser["name"] ?? "") ?></div>
    </div>

    <div class="mb-3">
      <div class="text-muted small">メールアドレス</div>
      <div><?= htmlspecialchars($currentUser["email"] ?? "") ?></div>
    </div>

    <a href="logout.php"
       class="btn btn-danger w-100 mt-3"
       onclick="return confirm('ログアウトしますか？')">
       ログアウト
    </a>

  </div>
</div>