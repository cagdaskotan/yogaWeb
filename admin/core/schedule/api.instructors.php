<?php
ob_start();
session_save_path("../../../env/sessions");
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../schedule/class.instructors.php");

// Ekleme
if (isset($_POST['add_instructor'])) {
    $name = trim($_POST['instructor_name'] ?? '');
    $surname = trim($_POST['instructor_surname'] ?? '');
    $imageName = 'media/instructors/default.jpg';

    if ($name == '' || $surname == '') {
        echo json_encode(['status' => 'error', 'message' => 'Ad ve soyad boş olamaz.']);
        exit;
    }

    if (isset($_FILES['instructor_image']) && $_FILES['instructor_image']['error'] === 0) {
        $tmp = $_FILES['instructor_image']['tmp_name'];
        $nameOnServer = uniqid() . '_' . basename($_FILES['instructor_image']['name']);
        $uploadPath = "../../../media/instructors/" . $nameOnServer;

        if (move_uploaded_file($tmp, $uploadPath)) {
            $imageName = 'media/instructors/' . $nameOnServer;
        }
    }

    $data = [
        'name' => $db->rescape($name),
        'surname' => $db->rescape($surname),
        'image' => $db->rescape($imageName)
    ];

    if ($db->insertData('instructors', $data)) {
        echo json_encode(['status' => 'success', 'message' => 'Eğitmen başarıyla eklendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ekleme sırasında hata oluştu.']);
    }
    exit;
}

// Güncelleme
if (isset($_POST['edit_instructor'])) {
    $id = intval($_POST['instructor_id'] ?? 0);
    $name = trim($_POST['instructor_name'] ?? '');
    $surname = trim($_POST['instructor_surname'] ?? '');

    $current = $instructors->get($id);
    $currentImage = $current->image ?? 'media/instructors/default.jpg'; 
    $imageName = $currentImage;

    if ($id <= 0 || $name == '' || $surname == '') {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz veri.']);
        exit;
    }
    
    if (isset($_FILES['instructor_image']) && $_FILES['instructor_image']['error'] === 0) {
        $tmp = $_FILES['instructor_image']['tmp_name'];
        $newFileName = uniqid() . '_' . basename($_FILES['instructor_image']['name']);
        $uploadPath = "../../../media/instructors/" . $newFileName;

        if (move_uploaded_file($tmp, $uploadPath)) {
            $imageName = 'media/instructors/' . $newFileName;

            $oldImagePath = "../../../" . $currentImage;
            if (!empty($currentImage) && file_exists($oldImagePath) && $currentImage !== 'media/instructors/default.jpg') {
                unlink($oldImagePath);
            }
        }
    }

    $data = [
        'name' => $db->rescape($name),
        'surname' => $db->rescape($surname),
        'image' => $db->rescape($imageName)
    ];

    if ($db->updateData('instructors', $data, $id)) {
        echo json_encode(['status' => 'success', 'message' => 'Eğitmen güncellendi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Güncelleme başarısız.']);
    }
    exit;
}

// Silme
if (isset($_POST['delete_instructor'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz eğitmen ID.']);
        exit;
    }

    $instructor = $instructors->get($id);
    $image = $instructor->image ?? 'media/instructors/default.jpg';

    // default değilse klasörden sil
    if ($image !== 'media/instructors/default.jpg') {
        $imagePath = "../../../" . $image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    if ($db->q("DELETE FROM instructors WHERE id = {$id}")) {
        echo json_encode(['status' => 'success', 'message' => 'Eğitmen silindi.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Silme başarısız.']);
    }
    exit;
}

// Tek eğitmen getir
if (isset($_POST['get_instructor'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz ID.']);
        exit;
    }

    $r = $instructors->get($id);
    if ($r) {
        echo json_encode(['status' => 'success', 'data' => $r]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Eğitmen bulunamadı.']);
    }
    exit;
}
?>
