<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("class.events.php");

function generateSlug($text) {
    $text = trim($text);
    
    // Büyük harfleri küçült (Türkçe destekli)
    $text = mb_convert_case($text, MB_CASE_LOWER, 'UTF-8');

    // Türkçe karakterleri çevir
    $tr = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ'];
    $en = ['i', 'g', 'u', 's', 'o', 'c', 'i'];
    $text = str_replace($tr, $en, $text);

    // Noktalama ve özel karakterleri kaldır
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text); // boşluk ve benzerleri -> -
    $text = preg_replace('~[^-\w]+~', '', $text);       // harf ve rakam dışını sil
    $text = trim($text, '-');                           // baştaki ve sondaki - sil
    $text = preg_replace('~-+~', '-', $text);           // birden fazla -'yi teke indir

    return $text;
}


$response = ['status' => 400, 'message' => 'Beklenmeyen bir hata oluştu.'];

// --- Ekle ---
if (isset($_POST['add_event'])) {
    $errors = [];

    if (empty($_POST['title'])) $errors[] = "Etkinlik başlığı boş bırakılamaz.";
    if (empty($_POST['start_date'])) $errors[] = "Başlangıç tarihi seçilmelidir.";

    if (count($errors) > 0) {
        $response = ['status' => 300, 'message' => implode("\n", $errors)];
    } else {
        $slug = generateSlug($_POST['title']);
        $data = [
            'title' => $db->rescape($_POST['title']),
            'start_date' => $db->rescape($_POST['start_date']),
            'end_date' => !empty($_POST['end_date']) ? $db->rescape($_POST['end_date']) : null,
            'is_active' => 1,
            'slug' => $db->rescape($slug)
        ];

        if ($db->insertData('events', $data)) {
            $response = ['status' => 200, 'message' => 'Etkinlik başarıyla eklendi.'];
        }
    }
}

// --- Güncelle ---
if (isset($_POST['edit_event'])) {
    $id = intval($_POST['event_id'] ?? 0);
    $errors = [];

    if (empty($_POST['title'])) $errors[] = "Etkinlik başlığı boş bırakılamaz.";
    if (empty($_POST['start_date'])) $errors[] = "Başlangıç tarihi seçilmelidir.";
    //if (empty($_POST['end_date'])) $errors[] = "Bitiş tarihi seçilmelidir.";

    if ($id == 0) $errors[] = "Etkinlik ID geçersiz.";

    if (count($errors) > 0) {
        $response = ['status' => 300, 'message' => implode("\n", $errors)];
    } else {
        $slug = generateSlug($_POST['title']);
        $data = [
            'title' => $db->rescape($_POST['title']),
            'start_date' => $db->rescape($_POST['start_date']),
            'end_date' => !empty($_POST['end_date']) ? $db->rescape($_POST['end_date']) : null,
            'slug' => $db->rescape($slug)
        ];


        if ($db->updateData('events', $data, $id)) {
            $response = ['status' => 200, 'message' => 'Etkinlik başarıyla güncellendi.'];
        } else {
            $response = ['status' => 400, 'message' => 'Güncelleme sırasında hata oluştu.'];
        }
    }
}

// --- Aktiflik ---
if (isset($_POST['activate'])) {
    $id = intval($_POST['id'] ?? 0);
    $state = $_POST['activate'];

    if ($state == 'true') {
        $data = ['is_active' => 1];
        $msg = 'Etkinlik yayına alındı.';
        $cls = 'bg-success';
    } else {
        $data = ['is_active' => 0];
        $msg = 'Etkinlik yayından kaldırıldı.';
        $cls = 'bg-danger';
    }

    if ($db->updateData('events', $data, $id)) {
        echo json_encode(['status' => 200, 'message' => $msg, 'cls' => $cls]);
        exit;
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        exit;
    }
}

// --- Etkinlik Ön Bilgi (Düzenleme Modalı için) ---
if(isset($_POST['prep_event'])) {
    $id = intval($_POST['id']);
    $q = $db->q("SELECT * FROM events WHERE id = {$id}");
    $r = $db->object($q);

    echo json_encode([
        'id' => $r->id,
        'title' => $r->title,
        'start_date' => $r->start_date,
        'end_date' => $r->end_date
    ]);
    exit;
}

// --- Sil ---
if (isset($_POST['delete_event'])) {
    $id = intval($_POST['id']);
    $q = $db->q("DELETE FROM events WHERE id = {$id}");

    if ($q) {
        $response = ['status' => 200, 'message' => 'Etkinlik başarıyla silindi.'];
    } else {
        $response = ['status' => 400, 'message' => 'Silme işlemi başarısız oldu.'];
    }
}

echo json_encode($response);
