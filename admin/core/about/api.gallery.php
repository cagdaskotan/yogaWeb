<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");

$response = ['status' => 400, 'message' => 'Beklenmeyen bir hata oluştu.'];

// --- Görsel Ekle ---
if (isset($_POST['add_gallery'])) {
    if (!empty($_FILES['images'])) {
        $files = $_FILES['images'];
        $total = count($files['name']);
        $uploaded = 0;

        for ($i = 0; $i < $total; $i++) {
            $tmp_name = $files['tmp_name'][$i];
            $name = time() . '_' . rand(1000, 9999) . '_' . basename($files['name'][$i]);
            $target_path = '../../../media/about/' . $name;

            if (move_uploaded_file($tmp_name, $target_path)) {
                $db->insertData('about_gallery', ['image' => 'media/about/' . $name]);
                $uploaded++;
            }
        }

        if ($uploaded > 0) {
            $response = ['status' => 200, 'message' => "$uploaded görsel başarıyla yüklendi."];
        } else {
            $response = ['status' => 400, 'message' => "Görseller yüklenemedi."];
        }
    }
}

// --- Görsel Sil ---
if (isset($_POST['delete_gallery'])) {
    $id = intval($_POST['id']);
    $q = $db->q("SELECT * FROM about_gallery WHERE id = {$id} LIMIT 1");
    $r = $db->object($q);

    if ($r && file_exists('../../../' . $r->image)) {
        unlink('../../../' . $r->image);
    }

    if ($db->q("DELETE FROM about_gallery WHERE id = {$id}")) {
        $response = ['status' => 200, 'message' => 'Görsel başarıyla silindi.'];
    } else {
        $response = ['status' => 400, 'message' => 'Silme işlemi başarısız oldu.'];
    }

    echo json_encode($response);
    exit;
}


echo json_encode($response);
