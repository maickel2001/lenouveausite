<?php $theme = $config['theme'] ?? []; ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($config['site_name'] ?? 'SMM Premium') ?></title>
  <link rel="stylesheet" href="/assets/css/app.css">
  <style>
    :root {
      --primary: <?= htmlspecialchars($theme['primary_color'] ?? '#ff7a00') ?>;
      --bg: <?= htmlspecialchars($theme['dark_background'] ?? '#0f0f10') ?>;
      --surface: <?= htmlspecialchars($theme['dark_surface'] ?? '#151517') ?>;
      --text: <?= htmlspecialchars($theme['light_text'] ?? '#f5f5f7') ?>;
      --muted: <?= htmlspecialchars($theme['muted_text'] ?? '#b3b3b3') ?>;
    }
  </style>
</head>
<body>
  <header class="container p-16">
    <div class="card flex-between">
      <div class="brand">
        <a class="brand-link" href="/"><?= htmlspecialchars($config['site_name'] ?? 'SMM Premium') ?></a>
      </div>
      <nav class="nav">
        <a href="/" class="nav-link">Accueil</a>
        <a href="/login" class="nav-link">Connexion</a>
        <a href="/register" class="button button-primary">Inscription</a>
      </nav>
    </div>
  </header>

  <?php App\Core\View::partial('partials/banner'); ?>
  <?php App\Core\View::partial('partials/flash'); ?>

  <main class="container p-16">
    <div class="card">
      <?= $content ?>
    </div>
  </main>

  <footer class="container p-16">
    <div class="muted">© <?= date('Y') ?> <?= htmlspecialchars($config['site_name'] ?? 'SMM Premium') ?> — Tous droits réservés.</div>
  </footer>
</body>
</html>
