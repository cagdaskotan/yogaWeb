<?php
ob_start();
session_save_path("../../../env/sessions");
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../schedule/class.classes.php");

// Ekleme
if (isset($_POST['add_class'])) {
    $name = trim($_POST['class'] ?? '');

    if ($name == '') {
        echo json_encode(['status' => 'error', 'message' => 'Sınıf adı boş olamaz.']);
        exit;
    }

    $data = ['class' => $db->rescape($name)];
    if ($db->insertData('classes', $data)) {
        echo json_encode(['status' => 'success', 'message' => 'Sınıf başarıyla eklendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ekleme sırasında hata oluştu.']);
    }
    exit;
}

// Güncelleme
if (isset($_POST['edit_class'])) {
    $id = intval($_POST['class_id'] ?? 0);
    $name = trim($_POST['class'] ?? '');

    if ($id <= 0 || $name == '') {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz veri.']);
        exit;
    }

    $data = ['class' => $db->rescape($name)];
    if ($db->updateData('classes', $data, $id)) {
        echo json_encode(['status' => 'success', 'message' => 'Sınıf güncellendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Güncelleme başarısız.']);
    }
    exit;
}

// Silme
if (isset($_POST['delete_class'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz sınıf ID.']);
        exit;
    }

    if ($db->q("DELETE FROM classes WHERE id = {$id}")) {
        echo json_encode(['status' => 'success', 'message' => 'Sınıf silindi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Silme başarısız.']);
    }
    exit;
}

// Tek sınıf getir
if (isset($_POST['get_class'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz ID.']);
        exit;
    }

    $r = $classes->get($id);
    if ($r) {
        echo json_encode(['status' => 'success', 'data' => $r]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Sınıf bulunamadı.']);
    }
    exit;
}
?>
