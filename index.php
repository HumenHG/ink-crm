<?php
require __DIR__ . '/inc/bootstrap.php';
if ($u = current_user()) { header('Location: ' . ($u['role'] === 'superadmin' ? 'admin/' : 'app.php')); exit; }
$slug = preg_match('/^[a-z0-9-]{1,60}$/', $_GET['e'] ?? '') ? $_GET['e'] : '';
$st = null;
if ($slug) { $q = db()->prepare('SELECT name, logo FROM studios WHERE slug=? AND active=1'); $q->execute([$slug]); $st = $q->fetch() ?: null; }
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $un = strtolower(trim($_POST['username'] ?? '')); $pw = (string)($_POST['password'] ?? ''); $ip = $_SERVER['REMOTE_ADDR'] ?? '';
  $pdo = db();
  $n1 = $pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip=? AND username=? AND at>NOW()-INTERVAL 15 MINUTE'); $n1->execute([$ip, $un]);
  $n2 = $pdo->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip=? AND at>NOW()-INTERVAL 15 MINUTE'); $n2->execute([$ip]);
  if (!csrf_ok($_POST['csrf'] ?? '')) $err = 'La sesión expiró. Intenta de nuevo.';
  elseif ($n1->fetchColumn() >= 5 || $n2->fetchColumn() >= 20) $err = 'Demasiados intentos. Espera 15 minutos.';
  else {
    $q = $pdo->prepare('SELECT u.*, s.slug, s.active AS sactive FROM users u LEFT JOIN studios s ON s.id=u.studio_id WHERE u.username=?'); $q->execute([$un]); $u = $q->fetch();
    $hash = $u['password_hash'] ?? '$2y$10$usesomesillystringforsaltandfakehashxxxxxxxxxxxxxxxxxxxxx';
    $ok = password_verify($pw, $hash) && $u && $u['active'] && ($u['role'] === 'superadmin' || ($u['sactive'] && (!$slug || $u['slug'] === $slug)));
    if ($ok) {
      $pdo->prepare('DELETE FROM login_attempts WHERE ip=? AND username=?')->execute([$ip, $un]);
      session_regenerate_id(true); $_SESSION['uid'] = (int)$u['id']; unset($_SESSION['csrf']);
      if (password_needs_rehash($u['password_hash'], PASSWORD_DEFAULT)) $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($pw, PASSWORD_DEFAULT), $u['id']]);
      $pdo->prepare('UPDATE users SET last_login=NOW() WHERE id=?')->execute([$u['id']]);
      header('Location: ' . ($u['role'] === 'superadmin' ? 'admin/' : 'app.php')); exit;
    }
    $pdo->exec('DELETE FROM login_attempts WHERE at<NOW()-INTERVAL 1 DAY');
    $pdo->prepare('INSERT INTO login_attempts (ip, username) VALUES (?,?)')->execute([$ip, substr($un, 0, 60)]);
    $err = 'Usuario o contraseña incorrectos.';
  }
}
$title = $st['name'] ?? 'Ink CRM';
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Iniciar sesión · <?= e($title) ?></title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="assets/ui.css"></head><body>
<main class="center"><form class="cd" method="post" autocomplete="on">
  <div class="head"><?php if (!empty($st['logo'])): ?><img class="logo" src="<?= e($st['logo']) ?>" alt=""><?php else: ?><div class="logo"><?= e(mb_strtoupper(mb_substr($title, 0, 1))) ?></div><?php endif; ?>
  <div><h1><?= e($title) ?></h1><span class="mu">Inicia sesión para continuar</span></div></div>
  <?php if ($err): ?><div class="err" role="alert"><?= e($err) ?></div><?php endif; ?>
  <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
  <label>Usuario<input name="username" autocomplete="username" autocapitalize="none" required autofocus value="<?= e($_POST['username'] ?? '') ?>"></label>
  <label>Contraseña<input name="password" type="password" autocomplete="current-password" required></label>
  <button class="btn" style="width:100%;margin-top:4px">Entrar</button>
</form></main></body></html>
