<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("class.products.php");



function generateSlug($text) {
    $text = trim($text);
    $text = mb_strtolower($text, 'UTF-8');

    // Türkçe karakter düzeltmeleri
    $search = ['ı','ğ','ü','ş','ö','ç','İ'];
    $replace = ['i','g','u','s','o','c','i'];
    $text = str_replace($search, $replace, $text);

    // Temizleme ve tireleme
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);

    return $text;
}

// JSON helper
function json_response($status, $message, $data = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

// Admin kontrolü
if (!isset($_SESSION['admin'])) {
    json_response('error', 'Yetkisiz erişim. Lütfen giriş yapın.');
}

// --- CREATE ---
if (isset($_POST['add_product'])) {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image = $_FILES['image'] ?? null;
    $isActive = 1;

    $uploadDir = "../../../media/products/";
    $fileName = time() . "_" . basename($image['name']);
    $targetPath = $uploadDir . $fileName;

    $imagePath = '';
    if (!empty($image) && $image['size'] > 0) {
        if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
            json_response('error', 'Görsel yüklenemedi.');
        }
        $imagePath = str_replace("../../../", "", $targetPath);
    }

    $slug = generateSlug($name);
    $data = [
        'name' => $db->rescape($name),
        'price' => $db->rescape($price),
        'category_id' => intval($category_id),
        'description' => $db->rescape($description),
        'image' => $imagePath,
        'is_active' => $isActive,
        'slug' => $db->rescape($slug)
    ];

    if ($db->insertData("products", $data)) {
        json_response('success', 'Ürün başarıyla eklendi.');
    } else {
        json_response('error', 'Ürün eklenirken hata oluştu.');
    }
    exit;
}

// --- READ (tek ürün) ---
if (isset($_POST['get_product'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        json_response('error', 'Geçersiz ürün ID.');
    }

    $product = $products->get($id);
    if ($product) {
        json_response('success', 'Ürün bilgileri alındı.', $product);
    } else {
        json_response('error', 'Ürün bulunamadı.');
    }
}

// --- UPDATE ---
if (isset($_POST['edit_product'])) {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $image = $_FILES['image'] ?? null;

    if ($id <= 0) {
        json_response('error', 'Geçersiz ürün ID.');
    }

    $slug = generateSlug($name);
    $data = [
        'name' => $db->rescape($name),
        'price' => $db->rescape($price),
        'category_id' => intval($category_id),
        'description' => $db->rescape($description),
        'slug' => $db->rescape($slug),
    ];

    if (!empty($image) && $image['size'] > 0) {
        $oldProduct = $products->get($id);
        $oldImagePath = "../../../" . ($oldProduct->image ?? '');

        if ($oldProduct && !empty($oldProduct->image) && file_exists($oldImagePath) && strpos($oldProduct->image, 'default.jpg') === false) {
            unlink($oldImagePath);
        }

        $uploadDir = "../../../media/products/";
        $fileName = time() . "_" . basename($image['name']);
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($image['tmp_name'], $targetPath)) {
            json_response('error', 'Görsel yüklenemedi.');
        }

        $data['image'] = str_replace("../../../", "", $targetPath);
    }

    if ($db->updateData("products", $data, $id)) {
        json_response('success', 'Ürün güncellendi.');
    } else {
        json_response('error', 'Güncelleme başarısız.');
    }
}

// --- DELETE ---
if (isset($_POST['delete_product'])) {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        json_response('error', 'Geçersiz ürün ID.');
    }

    if ($db->q("DELETE FROM products WHERE id = $id")) {
        json_response('success', 'Ürün silindi.');
    } else {
        json_response('error', 'Silme işlemi başarısız.');
    }
}

if (isset($_POST['activate'])) {
    $stat = $_POST['activate'];
    $id = intval($_POST['id']);

    if ($stat === 'true') {
        $data = ['is_active' => 1];
        $msg = 'Ürün yayına alındı.';
        $cls = 'bg-success';
    }

    if ($stat === 'false') {
        $data = ['is_active' => 0];
        $msg = 'Ürün yayından kaldırıldı.';
        $cls = 'bg-danger';
    }

    if ($db->updateData('products', $data, $id)) {
        echo json_encode(['status' => 200, 'message' => $msg, 'cls' => $cls]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

?>