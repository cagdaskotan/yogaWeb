<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");

$response = ['status' => 400, 'message' => 'Beklenmeyen bir hata oluştu.'];

if (isset($_POST['update_contact'])) {
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $facebook_url = trim($_POST['facebook_url'] ?? '');
    $instagram_url = trim($_POST['instagram_url'] ?? '');
    $youtube_url = trim($_POST['youtube_url'] ?? '');
    $x_url = trim($_POST['x_url'] ?? '');
    $map_embed_code = trim($_POST['map_embed_code'] ?? '');

    if ($address === '' || $phone === '' || $email === '') {
        $response = ['status' => 300, 'message' => 'Adres, telefon ve e-posta boş bırakılamaz.'];
    } else {
        // Güvenli veri için escaping
        $address = $db->rescape($address);
        $phone = $db->rescape($phone);
        $email = $db->rescape($email);
        $facebook_url = $db->rescape($facebook_url);
        $instagram_url = $db->rescape($instagram_url);
        $youtube_url = $db->rescape($youtube_url);
        $x_url = $db->rescape($x_url);
        $map_embed_code = $db->rescape($map_embed_code);

        // Kayıt var mı kontrolü
        $check = $db->q("SELECT id FROM contact LIMIT 1");

        if ($db->numrows($check) == 0) {
            // İlk defa kayıt ekleniyor
            $insert = $db->q("INSERT INTO contact 
                (address, phone, email, facebook_url, instagram_url, youtube_url, x_url, map_embed_code)
                VALUES 
                ('$address', '$phone', '$email', '$facebook_url', '$instagram_url', '$youtube_url', '$x_url', '$map_embed_code')");

            if ($insert) {
                $response = ['status' => 200, 'message' => 'İletişim bilgileri başarıyla eklendi.'];
            } else {
                $response = ['status' => 400, 'message' => 'Ekleme işlemi başarısız oldu.'];
            }
        } else {
            // Güncelleme yapılacak (id = 1)
            $update = $db->q("UPDATE contact SET 
                address = '$address',
                phone = '$phone',
                email = '$email',
                facebook_url = '$facebook_url',
                instagram_url = '$instagram_url',
                youtube_url = '$youtube_url',
                x_url = '$x_url',
                map_embed_code = '$map_embed_code'
                WHERE id = 1");

            if ($update) {
                $response = ['status' => 200, 'message' => 'İletişim bilgileri başarıyla güncellendi.'];
            } else {
                $response = ['status' => 400, 'message' => 'Güncelleme başarısız oldu.'];
            }
        }
    }
}

echo json_encode($response);
