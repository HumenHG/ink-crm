<?php
declare(strict_types=1);
$cfgFile = __DIR__ . '/../config/config.local.php';
if (!is_file($cfgFile)) { http_response_code(500); exit('Falta config/config.local.php'); }
$CFG = require $cfgFile;
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
if (PHP_SAPI !== 'cli') {
  session_name('inkcrm');
  session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$https,'httponly'=>true,'samesite'=>'Lax']);
  session_start();
  header('X-Frame-Options: DENY'); header('X-Content-Type-Options: nosniff'); header('Referrer-Policy: same-origin');
  header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src https://fonts.gstatic.com; img-src 'self' data: blob:; connect-src 'self'; frame-ancestors 'none'; base-uri 'self'; form-action 'self'");
  if (isset($_SESSION['t']) && time() - $_SESSION['t'] > 43200) { $_SESSION = []; session_regenerate_id(true); }
  $_SESSION['t'] = time();
}
function db(): PDO {
  static $p; global $CFG;
  return $p ??= new PDO("mysql:host={$CFG['db_host']};dbname={$CFG['db_name']};charset=utf8mb4", $CFG['db_user'], $CFG['db_pass'],
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES=>false]);
}
function e($s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf(): string { return $_SESSION['csrf'] ??= bin2hex(random_bytes(32)); }
function csrf_ok($t): bool { return is_string($t) && hash_equals(csrf(), $t); }
function json_out($d, int $c = 200): void { http_response_code($c); header('Content-Type: application/json; charset=utf-8'); echo json_encode($d, JSON_UNESCAPED_UNICODE); exit; }
function current_user(): ?array {
  if (empty($_SESSION['uid'])) return null;
  $s = db()->prepare('SELECT u.*, s.name AS sname, s.slug, s.logo, s.active AS sactive FROM users u LEFT JOIN studios s ON s.id=u.studio_id WHERE u.id=?');
  $s->execute([$_SESSION['uid']]); $u = $s->fetch();
  if (!$u || !$u['active'] || ($u['role'] === 'studio' && !$u['sactive'])) { $_SESSION = []; return null; }
  return $u;
}
function need_user(string $role, bool $json = false): array {
  $u = current_user();
  if (!$u || $u['role'] !== $role) {
    if ($json) json_out(['error' => 'auth'], 401);
    $in_admin = $role === 'superadmin';
    $to = $u ? ($u['role'] === 'superadmin' ? ($in_admin ? '' : 'admin/') : ($in_admin ? '../app.php' : 'app.php')) : ($in_admin ? '../index.php' : 'index.php');
    header('Location: ' . $to); exit;
  }
  return $u;
}
function slugify(string $s): string {
  $t = iconv('UTF-8', 'ASCII//TRANSLIT', $s); if ($t === false) $t = $s;
  $t = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $t), '-'));
  return $t !== '' ? substr($t, 0, 50) : 'estudio';
}
function gen_password(int $n = 12): string {
  $a = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789'; $o = '';
  for ($i = 0; $i < $n; $i++) $o .= $a[random_int(0, strlen($a) - 1)];
  return $o;
}
function save_logo(array $f): ?string {
  if (($f['error'] ?? 4) === 4) return null;
  if ($f['error'] !== 0 || $f['size'] > 2097152) throw new RuntimeException('El logo debe pesar menos de 2 MB.');
  $i = @getimagesize($f['tmp_name']); $ext = ['image/png'=>'png','image/jpeg'=>'jpg','image/webp'=>'webp'][$i['mime'] ?? ''] ?? null;
  if (!$ext) throw new RuntimeException('Logo no válido (usa PNG, JPG o WEBP).');
  $name = 'uploads/logos/' . bin2hex(random_bytes(10)) . '.' . $ext;
  if (!move_uploaded_file($f['tmp_name'], __DIR__ . '/../' . $name)) throw new RuntimeException('No se pudo guardar el logo.');
  return $name;
}
function del_logo(?string $p): void { if ($p && preg_match('#^uploads/logos/[a-f0-9]+\.(png|jpg|webp)$#', $p)) @unlink(__DIR__ . '/../' . $p); }
