<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");

$response = ['status' => 400, 'message' => 'Beklenmeyen bir hata oluştu.'];

if (isset($_POST['update_about'])) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $article = isset($_POST['article']) ? trim($_POST['article']) : '';

    if ($title === '' || $article === '') {
        $response = ['status' => 300, 'message' => 'Başlık ve içerik boş bırakılamaz.'];
    } else {
        $title = $db->rescape($title);
        $article = $db->rescape($article);

        $check = $db->q("SELECT id FROM about LIMIT 1");

        if ($db->numrows($check) == 0) {
            $insert = $db->q("INSERT INTO about (title, article) VALUES ('$title', '$article')");
            if ($insert) {
                $response = ['status' => 200, 'message' => 'Hakkımızda bilgisi başarıyla eklendi.'];
            } else {
                $response = ['status' => 400, 'message' => 'Ekleme işlemi başarısız oldu.'];
            }
        } else {
            $update = $db->q("UPDATE about SET title = '$title', article = '$article' WHERE id = 1");
            if ($update) {
                $response = ['status' => 200, 'message' => 'Hakkımızda bilgisi başarıyla güncellendi.'];
            } else {
                $response = ['status' => 400, 'message' => 'Güncelleme başarısız oldu.'];
            }
        }
    }
}

echo json_encode($response);
?>
