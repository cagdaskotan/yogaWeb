<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");

$response = ['status' => 400, 'message' => 'Beklenmeyen bir hata oluştu.'];

// --- Ekle ---
if (isset($_POST['add_education'])) {
    $errors = [];

    if (empty($_POST['title'])) $errors[] = "Eğitim veren kurum boş bırakılamaz.";
    if (empty($_POST['description'])) $errors[] = "Eğitim açıklaması boş bırakılamaz.";

    if (count($errors) > 0) {
        $response = ['status' => 300, 'message' => implode("\n", $errors)];
    } else {
        $data = [
            'title' => $db->rescape($_POST['title']),
            'description' => $db->rescape($_POST['description'])
        ];

        if ($db->insertData('about_educations', $data)) {
            $response = ['status' => 200, 'message' => 'Eğitim başarıyla eklendi.'];
        }
    }
}

// --- Güncelle ---
if (isset($_POST['edit_education'])) {
    $id = intval($_POST['education_id'] ?? 0);
    $errors = [];

    if ($id == 0) $errors[] = "Eğitim ID geçersiz.";
    if (empty($_POST['title'])) $errors[] = "Eğitim veren kurum boş bırakılamaz.";
    if (empty($_POST['description'])) $errors[] = "Eğitim açıklaması boş bırakılamaz.";

    if (count($errors) > 0) {
        $response = ['status' => 300, 'message' => implode("\n", $errors)];
    } else {
        $data = [
            'title' => $db->rescape($_POST['title']),
            'description' => $db->rescape($_POST['description'])
        ];

        if ($db->updateData('about_educations', $data, $id)) {
            $response = ['status' => 200, 'message' => 'Eğitim başarıyla güncellendi.'];
        } else {
            $response = ['status' => 400, 'message' => 'Güncelleme sırasında hata oluştu.'];
        }
    }
}

// --- Bilgi Getir (Düzenleme Modalı) ---
if (isset($_POST['prep_education'])) {
    $id = intval($_POST['id']);
    $q = $db->q("SELECT * FROM about_educations WHERE id = {$id}");
    $r = $db->object($q);

    echo json_encode([
        'id' => $r->id,
        'title' => $r->title,
        'description' => $r->description
    ]);
    exit;
}

// --- Sil ---
if (isset($_POST['delete_education'])) {
    $id = intval($_POST['id']);
    $q = $db->q("DELETE FROM about_educations WHERE id = {$id}");

    if ($q) {
        $response = ['status' => 200, 'message' => 'Eğitim başarıyla silindi.'];
    } else {
        $response = ['status' => 400, 'message' => 'Silme işlemi başarısız oldu.'];
    }
}

if (isset($_POST['get_education'])) {
    $id = intval($_POST['id']);
    $q = $db->q("SELECT * FROM about_educations WHERE id = {$id}");
    $r = $db->object($q);

    echo json_encode([
        'id' => $r->id,
        'title' => $r->title,
        'description' => $r->description
    ]);
    exit;
}


echo json_encode($response);
