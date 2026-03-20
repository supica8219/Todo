<?php
$action = $_GET["action"] ?? "list";
/* フローティングボタンを出さない画面 */
$hideFab = ["add_task","edit","user"];
?>
<!-- フローティングボタン（必要な画面だけ） -->
<?php if(!in_array($action,$hideFab)): ?>
<a href="index.php?action=add_task"
   class="btn btn-primary rounded-circle position-fixed d-flex align-items-center justify-content-center"
   style="bottom: 80px; right: 20px; width: 60px; height: 60px; font-size:24px;">
  ＋
</a>
<?php endif; ?>
<!-- 下ナビ -->
<nav class="navbar bg-white fixed-bottom border-top">
  <div class="container-fluid d-flex justify-content-around">
    <a href="index.php" class="btn btn-link">🏠</a>
    <a href="index.php?action=add_task" class="btn btn-link">＋</a>
    <a href="index.php?action=user" class="btn btn-link">👤</a>
  </div>
</nav>
<!-- フラットピッカーの読み込み -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("#start_date", {
  dateFormat: "Y/m/d",
  locale: "ja",
  allowInput: true
});
flatpickr("#end_date", {
  dateFormat: "Y/m/d",
  locale: "ja",
  allowInput: true
});
</script>
<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/CRUD/service-worker.js')
      .then(reg => console.log('SW registered', reg))
      .catch(err => console.log('SW error', err));
  });
}
</script>
