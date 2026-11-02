<?php
// Ejecutar UNA vez: https://tudominio.com/setup.php?key=TU_SETUP_KEY  (o por consola: php setup.php)
require __DIR__ . '/inc/bootstrap.php';
header('Content-Type: text/plain; charset=utf-8');
if (PHP_SAPI !== 'cli' && (empty($CFG['setup_key']) || !hash_equals((string)$CFG['setup_key'], (string)($_GET['key'] ?? '')))) { http_response_code(403); exit("Acceso denegado.\n"); }
$lock = __DIR__ . '/storage/installed.lock';
if (is_file($lock)) exit("Ya instalado. Borra setup.php del servidor.\n");
$pdo = db();
foreach (array_filter(array_map('trim', explode(';', file_get_contents(__DIR__ . '/schema.sql')))) as $sql) $pdo->exec($sql);
if (!(int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn()) {
  $h = fn($p) => password_hash($p, PASSWORD_DEFAULT);
  $pdo->prepare("INSERT INTO users (role,name,username,password_hash) VALUES ('superadmin','Super Admin','superadmin',?)")->execute([$h('Ink-Super-2026!')]);
  $pdo->exec("INSERT INTO studios (name,slug) VALUES ('Estudio Demo','demo')");
  $sid = (int)$pdo->lastInsertId();
  $pdo->prepare("INSERT INTO users (studio_id,role,name,username,password_hash) VALUES (?,'studio','Tatuador Demo','demo',?)")->execute([$sid, $h('Ink-Demo-2026!')]);
}
file_put_contents($lock, date('c'));
echo "Listo.\n\nSuper admin : superadmin / Ink-Super-2026!   (entra en /)\nEstudio demo: demo / Ink-Demo-2026!   (entra en /?e=demo)\n\nCAMBIA estas contraseñas y borra setup.php.\n";
