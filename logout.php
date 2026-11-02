<?php
require __DIR__ . '/inc/bootstrap.php';
$slug = '';
if ($u = current_user()) $slug = $u['slug'] ?? '';
$_SESSION = []; session_destroy();
header('Location: index.php' . ($slug ? '?e=' . urlencode($slug) : '')); exit;
