<h5 class="mb-3">プロジェクト作成</h5>

<div class="card shadow-sm rounded-4">
  <div class="card-body p-4">

    <form method="post">

      <!-- プロジェクト名 -->
      <div class="mb-3">
        <label class="form-label">プロジェクト名</label>
        <input 
          type="text" 
          name="name" 
          class="form-control" 
          placeholder="例：ポートフォリオ開発"
          required
        >
      </div>

      <!-- 説明 -->
      <div class="mb-3">
        <label class="form-label">説明（任意）</label>
        <textarea 
          name="description" 
          class="form-control" 
          rows="3"
          placeholder="プロジェクトの概要を入力"
        ></textarea>
      </div>

      <!-- ボタン -->
      <div class="d-grid">
        <button class="btn btn-success">
          ＋ プロジェクトを作成
        </button>
      </div>

    </form>

  </div>
</div>

<!-- 戻る -->
<div class="text-center mt-3">
  <a href="index.php" class="text-muted small">
    ← タスク一覧に戻る
  </a>
</div>