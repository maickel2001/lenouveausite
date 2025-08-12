<?php $config = $config ?? (require dirname(__DIR__, 2) . '/config/config.php'); ?>
<?php use App\Helpers\Csrf; ?>
<h1 class="h2">Connexion</h1>
<form action="/login" method="post" class="form">
  <?= Csrf::field(); ?>
  <label class="label">Email
    <input type="email" name="email" required class="input" placeholder="vous@domaine.com">
  </label>
  <label class="label">Mot de passe
    <input type="password" name="password" required class="input" placeholder="••••••••">
  </label>
  <button class="button button-primary w-100" type="submit">Se connecter</button>
</form>
<p class="muted mt-12">Pas de compte ? <a href="/register">Inscrivez‑vous</a></p>
