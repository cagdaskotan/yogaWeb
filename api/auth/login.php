<?php
require_once("../../env/class.db.php");
require_once("../utils/jwt.php");

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['error' => 'Email ve şifre zorunlu.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Geçerli bir e-posta girin.']);
    exit;
}

$q = $db->q("SELECT * FROM users WHERE email = '{$db->rescape($email)}' AND is_active = 1");
$user = $db->fassoc($q);

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode(['error' => 'Giriş bilgileri hatalı.']);
    exit;
}

// Token üret
$jwt = new Jwt();
$token = $jwt->generate($user['id']);

echo json_encode([
    "status" => "success",
    "token" => $token,
    "user" => [
        "id" => $user['id'],
        "name" => $user['name'],
        "email" => $user['email'],
        "is_admin" => $user['is_admin']
    ]
]);
