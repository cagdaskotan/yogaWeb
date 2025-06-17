<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../schedule/class.schedule.php");

$schedule = new Schedule();

// --- Tek programı getir (Düzenleme için) ---
if (isset($_POST['get_schedule'])) {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['status' => 400, 'message' => 'Geçersiz ID']);
        exit;
    }

    $r = $schedule->get($id);
    if ($r) {
        echo json_encode(['status' => 200, 'data' => $r]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Kayıt bulunamadı.']);
    }
    exit;
}

// --- Silme ---
if(isset($_POST['delete_schedule'])) {
    $errors = array();
    $id = intval($_POST['id'] ?? 0);

    if($id <= 0) {
        $errors[] = 'Geçersiz program ID';
    }

    if(empty($errors)) {
        $q = $db->q("DELETE FROM schedule WHERE id = {$id}");
        if($q) {
            echo json_encode(['status' => 200, 'message' => 'Program başarıyla silindi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Silme işlemi başarısız oldu.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => implode("*", $errors)]);
    }
}

// --- Güncelleme ---
if(isset($_POST['edit_schedule'])) {
    $errors = array();

    $id = intval($_POST['id'] ?? 0);
    $class_id = intval($_POST['class_id'] ?? 0);
    $instructor_id = intval($_POST['instructor_id'] ?? 0);
    $day = intval($_POST['schedule_day'] ?? 0);
    $start = trim($_POST['start_time'] ?? '');
    $end = trim($_POST['end_time'] ?? '');

    if($id <= 0) $errors[] = 'Program ID bulunamadı';
    if($class_id <= 0) $errors[] = 'Sınıf seçilmedi';
    if($instructor_id <= 0) $errors[] = 'Eğitmen seçilmedi';
    if($day < 1 || $day > 7) $errors[] = 'Geçersiz gün';
    if(empty($start)) $errors[] = 'Başlangıç saati girilmedi';
    if(empty($end)) $errors[] = 'Bitiş saati girilmedi';

    if(count($errors) > 0) {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $data = [
            'class_id' => $db->rescape($class_id),
            'instructor_id' => $db->rescape($instructor_id),
            'schedule_day' => $db->rescape($day),
            'start_time' => $db->rescape($start),
            'end_time' => $db->rescape($end),
            'is_active' => 1
        ];

        if($db->updateData('schedule', $data, $id)) {
            echo json_encode(['status' => 200, 'message' => 'Program başarıyla güncellendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Güncelleme başarısız oldu.']);
        }
    }
}

// --- Ekleme ---
if(isset($_POST['add_schedule'])) {
    $errors = array();

    $class_id = intval($_POST['class_id'] ?? 0);
    $instructor_id = intval($_POST['instructor_id'] ?? 0);
    $day = intval($_POST['schedule_day'] ?? 0);
    $start = trim($_POST['start_time'] ?? '');
    $end = trim($_POST['end_time'] ?? '');

    if($class_id <= 0) $errors[] = 'Sınıf seçilmedi';
    if($instructor_id <= 0) $errors[] = 'Eğitmen seçilmedi';
    if($day < 1 || $day > 7) $errors[] = 'Geçersiz gün';
    if(empty($start)) $errors[] = 'Başlangıç saati girilmedi';
    if(empty($end)) $errors[] = 'Bitiş saati girilmedi';

    if(count($errors) > 0) {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $data = [
            'class_id' => $db->rescape($class_id),
            'instructor_id' => $db->rescape($instructor_id),
            'schedule_day' => $db->rescape($day),
            'start_time' => $db->rescape($start),
            'end_time' => $db->rescape($end),
            'is_active' => 1
        ];

        if($db->insertData('schedule', $data)) {
            echo json_encode(['status' => 200, 'message' => 'Program başarıyla eklendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'Ekleme başarısız oldu.']);
        }
    }
}

// -- Aktiflik --
if (isset($_POST['activate'])) {
    $stat = $_POST['activate'];
    $id = intval($_POST['id']);

    if ($stat === 'true') {
        $data = ['is_active' => 1];
        $msg = 'Program yayına alındı.';
        $cls = 'bg-success';
    }

    if ($stat === 'false') {
        $data = ['is_active' => 0];
        $msg = 'Program yayından kaldırıldı.';
        $cls = 'bg-danger';
    }

    if ($db->updateData('schedule', $data, $id)) {
        echo json_encode(['status' => 200, 'message' => $msg, 'cls' => $cls]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

?>
