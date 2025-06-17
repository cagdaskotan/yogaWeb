<?php
ob_start();
session_save_path("../../../env/sessions");
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("class.categories.php");

// JSON dönüş fonksiyonu
function json_response($status, $message, $data = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

// Admin kontrolü
if (!isset($_SESSION['admin'])) {
    json_response('error', 'Yetkisiz erişim. Lütfen giriş yapın.');
}

// --- CREATE ---
if (isset($_POST['add_category'])) {
    $name = trim($_POST['name'] ?? '');

    if ($name == '') {
        json_response('error', 'Kategori adı boş olamaz.');
    }

    $check = $db->q("SELECT id FROM categories WHERE name = '" . $db->rescape($name) . "'");
    if ($db->numrows($check) > 0) {
        json_response('error', 'Bu isimde bir kategori zaten var.');
    }

    $data = [
        'name' => $db->rescape($name),
        'created_at' => date("Y-m-d H:i:s")
    ];

    if ($db->insertData('categories', $data)) {
        json_response('success', 'Kategori başarıyla eklendi.');
    } else {
        json_response('error', 'Kategori eklenirken hata oluştu.');
    }
}

// --- READ ---
if (isset($_POST['get_category'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        json_response('error', 'Geçersiz kategori ID.');
    }

    $category = $categories->get($id);
    if ($category) {
        json_response('success', 'Kategori bilgileri alındı.', $category);
    } else {
        json_response('error', 'Kategori bulunamadı.');
    }
}

// --- UPDATE ---
if (isset($_POST['edit_category'])) {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');

    if ($id <= 0 || $name == '') {
        json_response('error', 'Kategori ID ve isim zorunludur.');
    }

    $data = ['name' => $db->rescape($name)];

    if ($db->updateData('categories', $data, $id)) {
        json_response('success', 'Kategori güncellendi.');
    } else {
        json_response('error', 'Güncelleme başarısız.');
    }
}

// --- DELETE ---
if (isset($_POST['delete_category'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        json_response('error', 'Geçersiz kategori ID.');
    }

    if ($db->q("DELETE FROM categories WHERE id = {$id}")) {
        json_response('success', 'Kategori silindi.');
    } else {
        json_response('error', 'Silme işlemi başarısız.');
    }
}

// --- Geçersiz istek ---
json_response('error', 'Geçersiz istek.');

?>