<?php
require_once '../../users/init.php';
header('Content-Type: application/json; charset=utf-8');

if (!$user->isLoggedIn() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(401);
    echo json_encode(['ok' => false, 'message' => 'Sesi login tidak valid.']);
    exit;
}

$token = isset($_POST['csrf']) && is_string($_POST['csrf']) ? $_POST['csrf'] : '';
if (!Token::check($token)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'message' => 'Token keamanan tidak valid. Muat ulang halaman.']);
    exit;
}

$mode = isset($_POST['is_light_mode']) ? (string)$_POST['is_light_mode'] : '';
$color1 = isset($_POST['color_1']) ? strtoupper(trim((string)$_POST['color_1'])) : '';
$color2 = isset($_POST['color_2']) ? strtoupper(trim((string)$_POST['color_2'])) : '';
if (!in_array($mode, ['0', '1'], true) || !preg_match('/^#[0-9A-F]{6}$/', $color1) || !preg_match('/^#[0-9A-F]{6}$/', $color2)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Tema atau warna tidak valid.']);
    exit;
}

$saved = $db->update('users', $user->data()->id, [
    'is_light_mode' => (int)$mode,
    'color_1' => $color1,
    'color_2' => $color2,
]);
if (!$saved) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Preferensi tidak berhasil disimpan.']);
    exit;
}

echo json_encode(['ok' => true]);
