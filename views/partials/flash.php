<?php use App\Helpers\Flash; $messages = Flash::all(); if (!empty($messages)): ?>
<div class="container p-16">
  <div class="card" style="border:1px solid rgba(255,255,255,.08)">
    <?php foreach ($messages as $type => $items): ?>
      <?php foreach ($items as $msg): ?>
        <div class="flash flash-<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($msg) ?></div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>
</div>
<style>
.flash { padding: 10px 12px; border-radius: 10px; margin-bottom: 8px; }
.flash-error { background: rgba(255,0,0,.12); color: #ffb3b3; border: 1px solid rgba(255,0,0,.25); }
.flash-success { background: rgba(0,255,0,.10); color: #b9ffb9; border: 1px solid rgba(0,255,0,.25); }
</style>
<?php endif; ?>
