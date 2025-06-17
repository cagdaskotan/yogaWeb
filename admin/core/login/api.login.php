<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");

if(isset($_POST['login_admin'])){

    if(empty($_POST['email']) || empty($_POST['password']) || empty($_POST['securityCode'])) {
        echo json_encode(['status' => 'error', 'message' => 'Lütfen tüm alanları doldurunuz.']);
        exit;
    }

    if (strcasecmp($_SESSION['captcha'], $_POST['securityCode']) != 0) {
        echo json_encode(['status' => 'error', 'message' => 'Güvenlik kodunu yanlış girdiniz.']);
        exit;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Lütfen geçerli bir e-posta adresi giriniz.']);
        exit;
    }

    $email = $db->rescape($_POST['email']);

    $q = $db->q("SELECT * FROM users WHERE email = '$email' AND is_admin = 1 AND is_active = 1 LIMIT 1");
    if($db->numrows($q) <= 0){
        echo json_encode(['status' => 'error', 'message' => 'Bilgileriniz hatalı. Lütfen kontrol ediniz.']);
        exit;
    }

    $r = $db->object($q);

    if (!password_verify($_POST['password'], $r->password)) {
        echo json_encode(['status' => 'error', 'message' => 'Bilgileriniz hatalı. Lütfen kontrol ediniz.']);
        exit;
    }
    
    $_SESSION['admin'] = $r->id;
    echo json_encode(['status' => 'success', 'message' => 'Giriş başarılı. Yönlendiriliyorsunuz...']);
    exit;

}
?>