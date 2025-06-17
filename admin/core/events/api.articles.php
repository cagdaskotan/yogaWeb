<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../users/class.users.php");
require_once("../class.func.php");

// --- Ekle ---
if (isset($_POST['add_art'])) {
    $errors = [];

    $article = $_POST['article'] ?? '';
    $event_id = intval($_POST['event_id'] ?? 0);

    if (trim($article) == '') $errors[] = 'İçerik boş olamaz.';
    if ($event_id == 0) $errors[] = 'Etkinlik bilgisi eksik.';

    if (!empty($errors)) {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $data = [
            'event_id' => $event_id,
            'article' => $db->rescape($article)
        ];

        if ($db->insertData('events_articles', $data)) {
            echo json_encode(['status' => 200, 'message' => 'İçerik başarıyla eklendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Veritabanı hatası oluştu.']);
        }
    }
}

// ---Güncelle ---
if (isset($_POST['edit_art'])) {
    $errors = [];

    $article = $_POST['article'] ?? '';
    $id = intval($_POST['article_id'] ?? 0);

    if (trim($article) == '') $errors[] = 'İçerik boş olamaz.';
    if ($id == 0) $errors[] = 'İçerik bulunamadı.';

    if (!empty($errors)) {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $data = ['article' => $db->rescape($article)];

        if ($db->updateData('events_articles', $data, $id)) {
            echo json_encode(['status' => 200, 'message' => 'İçerik başarıyla güncellendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Güncelleme başarısız oldu.']);
        }
    }
}

// --- Sil ---
if (isset($_POST['del_art'])) {
    $id = $db->rescape($_POST['id']);

    if ($id == '') {
        echo json_encode(['status' => 400, 'message' => 'İçerik bilgisi bulunamadı.']);
        exit;
    }

    $q = $db->q("DELETE FROM events_articles WHERE MD5(CONCAT('zsistem', id)) = '{$id}'");

    if ($q) {
        echo json_encode(['status' => 200, 'message' => 'Etkinlik içeriği başarıyla silindi.']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

?>
