<?php
require __DIR__ . '/inc/bootstrap.php';
$u = need_user('studio', true); $sid = (int)$u['studio_id']; $a = $_GET['a'] ?? '';
if ($a === 'load' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $s = db()->prepare('SELECT k, json FROM docs WHERE studio_id=?'); $s->execute([$sid]);
  json_out(['user' => ['name' => $u['name']], 'studio' => ['name' => $u['sname'], 'logo' => $u['logo']], 'docs' => $s->fetchAll()]);
}
if ($a === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!csrf_ok($_SERVER['HTTP_X_CSRF'] ?? '')) json_out(['error' => 'csrf'], 403);
  $raw = file_get_contents('php://input', false, null, 0, 12582912);
  $b = json_decode($raw ?: '', true);
  if (!is_array($b)) json_out(['error' => 'bad'], 400);
  $set = is_array($b['set'] ?? null) ? $b['set'] : []; $del = is_array($b['del'] ?? null) ? $b['del'] : [];
  if (count($set) > 300 || count($del) > 300) json_out(['error' => 'big'], 413);
  $ok = fn($k) => is_string($k) && preg_match('/^(c_|g_)[A-Za-z0-9]{1,40}$|^cfg$/', $k);
  $pdo = db(); $pdo->beginTransaction();
  $up = $pdo->prepare('INSERT INTO docs (studio_id,k,json) VALUES (?,?,?) ON DUPLICATE KEY UPDATE json=VALUES(json)');
  $dl = $pdo->prepare('DELETE FROM docs WHERE studio_id=? AND k=?');
  foreach ($set as $k => $j) {
    if (!$ok($k) || !is_string($j) || strlen($j) > 1600000 || !is_array(json_decode($j, true))) { $pdo->rollBack(); json_out(['error' => 'invalid'], 422); }
    $up->execute([$sid, $k, $j]);
  }
  foreach ($del as $k) if ($ok($k)) $dl->execute([$sid, $k]);
  $pdo->commit(); json_out(['ok' => true]);
}
json_out(['error' => 'not_found'], 404);
