<?php
require __DIR__ . '/../inc/bootstrap.php';
$me = need_user('superadmin'); $pdo = db(); $err = ''; $flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']);
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') ? 'https' : 'http';
$base = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
function done($flash = null) { if ($flash) $_SESSION['flash'] = $flash; header('Location: ./'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    if (!csrf_ok($_POST['csrf'] ?? '')) throw new RuntimeException('La sesión expiró. Recarga la página.');
    $act = $_POST['action'] ?? ''; $id = (int)($_POST['id'] ?? 0);
    if ($act === 'create') {
      $name = trim($_POST['name'] ?? ''); if ($name === '' || mb_strlen($name) > 120) throw new RuntimeException('Escribe el nombre del estudio.');
      $slug = slugify($name); $n = 1; $chk = $pdo->prepare('SELECT 1 FROM studios WHERE slug=?');
      while (true) { $chk->execute([$slug . ($n > 1 ? "-$n" : '')]); if (!$chk->fetch()) break; $n++; }
      $slug .= $n > 1 ? "-$n" : '';
      $un = strtolower(trim($_POST['username'] ?? '')) ?: str_replace('-', '', $slug);
      if (!preg_match('/^[a-z0-9._-]{3,40}$/', $un)) throw new RuntimeException('Usuario inválido (3-40 letras, números, . _ -).');
      $x = $pdo->prepare('SELECT 1 FROM users WHERE username=?'); $x->execute([$un]); if ($x->fetch()) throw new RuntimeException('Ese usuario ya existe.');
      $pw = trim($_POST['password'] ?? '') ?: gen_password(); if (strlen($pw) < 8) throw new RuntimeException('La contraseña debe tener al menos 8 caracteres.');
      $logo = save_logo($_FILES['logo'] ?? []);
      $pdo->beginTransaction();
      $pdo->prepare('INSERT INTO studios (name,slug,logo) VALUES (?,?,?)')->execute([$name, $slug, $logo]); $sid = (int)$pdo->lastInsertId();
      $pdo->prepare("INSERT INTO users (studio_id,role,name,username,password_hash) VALUES (?,'studio',?,?,?)")->execute([$sid, $name, $un, password_hash($pw, PASSWORD_DEFAULT)]);
      $pdo->commit();
      done(['t' => 'Estudio creado', 'studio' => $name, 'user' => $un, 'pass' => $pw, 'url' => "$base/?e=$slug"]);
    }
    $s = $pdo->prepare('SELECT * FROM studios WHERE id=?'); $s->execute([$id]); $st = $s->fetch(); if (!$st) throw new RuntimeException('Estudio no encontrado.');
    if ($act === 'toggle') { $pdo->prepare('UPDATE studios SET active=1-active WHERE id=?')->execute([$id]); done(); }
    if ($act === 'logo') { $l = save_logo($_FILES['logo'] ?? []); if ($l) { $pdo->prepare('UPDATE studios SET logo=? WHERE id=?')->execute([$l, $id]); del_logo($st['logo']); } done(); }
    if ($act === 'rename') { $nn = trim($_POST['name'] ?? ''); if ($nn !== '') $pdo->prepare('UPDATE studios SET name=? WHERE id=?')->execute([$nn, $id]); done(); }
    if ($act === 'reset') {
      $pw = gen_password(); $u = $pdo->prepare("SELECT username FROM users WHERE studio_id=? AND role='studio' ORDER BY id LIMIT 1"); $u->execute([$id]); $un = $u->fetchColumn();
      $pdo->prepare("UPDATE users SET password_hash=? WHERE studio_id=? AND role='studio'")->execute([password_hash($pw, PASSWORD_DEFAULT), $id]);
      done(['t' => 'Contraseña restablecida', 'studio' => $st['name'], 'user' => $un, 'pass' => $pw, 'url' => "$base/?e={$st['slug']}"]);
    }
    if ($act === 'delete') { $pdo->prepare('DELETE FROM studios WHERE id=?')->execute([$id]); del_logo($st['logo']); done(); }
    if ($act === 'mypass') {
      $pw = (string)($_POST['password'] ?? ''); if (strlen($pw) < 10) throw new RuntimeException('Usa al menos 10 caracteres.');
      $pdo->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($pw, PASSWORD_DEFAULT), $me['id']]);
      done(['t' => 'Tu contraseña se actualizó']);
    }
  } catch (Throwable $ex) { if ($pdo->inTransaction()) $pdo->rollBack(); $err = $ex instanceof RuntimeException ? $ex->getMessage() : 'Error del servidor.'; }
}
$rows = $pdo->query("SELECT s.*, (SELECT username FROM users WHERE studio_id=s.id AND role='studio' ORDER BY id LIMIT 1) AS un,
  (SELECT COUNT(*) FROM docs d WHERE d.studio_id=s.id AND d.k LIKE 'c\\_%') AS citas FROM studios s ORDER BY s.created_at DESC")->fetchAll();
$T = csrf();
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Super admin · Ink CRM</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
<link rel="stylesheet" href="../assets/ui.css"></head><body><div class="wrap">
<header class="top"><div><h1>Estudios</h1><span class="mu">Panel de super administrador · <?= e($me['name']) ?></span></div><a class="btn sec" href="../logout.php">Cerrar sesión</a></header>
<?php if ($err): ?><div class="err" role="alert"><?= e($err) ?></div><?php endif; ?>
<?php if ($flash): ?><div class="okb"><b><?= e($flash['t']) ?></b>
<?php if (!empty($flash['pass'])): ?><p class="mu" style="margin:6px 0 10px">Guarda estos datos y compártelos con el estudio <b><?= e($flash['studio']) ?></b>. La contraseña no se vuelve a mostrar.</p>
<p style="margin:4px 0">Enlace: <code><?= e($flash['url']) ?></code></p><p style="margin:4px 0">Usuario: <code><?= e($flash['user']) ?></code></p><p style="margin:4px 0">Contraseña: <code><?= e($flash['pass']) ?></code></p><?php endif; ?></div><?php endif; ?>
<div class="grid">
<div><form class="cd" method="post" enctype="multipart/form-data"><h2>Nuevo estudio</h2>
<input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="create">
<label>Nombre del estudio<input name="name" required maxlength="120"></label>
<label>Logo (PNG, JPG o WEBP, máx. 2 MB)<input type="file" name="logo" accept="image/png,image/jpeg,image/webp"></label>
<label>Usuario <span style="font-weight:400">(vacío = automático)</span><input name="username" autocapitalize="none" maxlength="40"></label>
<label>Contraseña <span style="font-weight:400">(vacío = generar)</span><input name="password" type="text" autocomplete="off" maxlength="72"></label>
<button class="btn" style="width:100%">Crear estudio</button></form>
<form class="cd" method="post" style="margin-top:18px"><h2>Mi contraseña</h2><input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="mypass">
<label>Nueva contraseña<input name="password" type="password" autocomplete="new-password" minlength="10" required></label><button class="btn sec" style="width:100%">Actualizar</button></form></div>
<div><?php foreach ($rows as $r): ?>
<section class="cd st"><?php if ($r['logo']): ?><img class="logo" src="../<?= e($r['logo']) ?>" alt=""><?php else: ?><div class="logo"><?= e(mb_strtoupper(mb_substr($r['name'], 0, 1))) ?></div><?php endif; ?>
<div style="min-width:0"><div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap"><h2 style="margin:0"><?= e($r['name']) ?></h2><span class="badge <?= $r['active'] ? 'on' : 'off' ?>"><?= $r['active'] ? 'Activo' : 'Suspendido' ?></span></div>
<small>Usuario <code><?= e($r['un'] ?? '—') ?></code> · <?= (int)$r['citas'] ?> citas · <code><?= e("$base/?e={$r['slug']}") ?></code></small>
<div class="row">
<form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="logo"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
<label class="btn sec sm" style="margin:0;cursor:pointer">Cambiar logo<input type="file" name="logo" accept="image/png,image/jpeg,image/webp" hidden onchange="this.form.submit()"></label></form>
<form method="post" onsubmit="return confirm('¿Generar una contraseña nueva para este estudio?')"><input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="reset"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn sec sm">Restablecer contraseña</button></form>
<form method="post"><input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn sec sm"><?= $r['active'] ? 'Suspender' : 'Reactivar' ?></button></form>
<form method="post" onsubmit="return confirm('Se borrarán el estudio, su usuario y TODAS sus citas. ¿Continuar?')"><input type="hidden" name="csrf" value="<?= e($T) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>"><button class="btn dng sm">Eliminar</button></form>
</div></div></section>
<?php endforeach; if (!$rows): ?><div class="cd mu">Aún no hay estudios. Crea el primero con el formulario.</div><?php endif; ?></div></div></div></body></html>
