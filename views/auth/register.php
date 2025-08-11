<?php $config = $config ?? (require dirname(__DIR__, 2) . '/config/config.php'); ?>
<?php use App\Helpers\Csrf; ?>
<h1 class="h2">Inscription</h1>
<form action="/register" method="post" class="form">
  <?= Csrf::field(); ?>
  <label class="label">Nom
    <input type="text" name="name" required class="input" placeholder="Votre nom">
  </label>
  <label class="label">Email
    <input type="email" name="email" required class="input" placeholder="vous@domaine.com">
  </label>
  <label class="label">Mot de passe
    <input type="password" name="password" required class="input" placeholder="••••••••">
  </label>
  <button class="button button-primary w-100" type="submit">Créer un compte</button>
</form>
<p class="muted mt-12">Déjà inscrit ? <a href="/login">Connectez‑vous</a></p>
