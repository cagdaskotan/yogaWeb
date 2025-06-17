<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../users/class.users.php");
require_once("../class.func.php");

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

// SUBJECTS
if(isset($_POST['add_subject']))
{
    $errors = [];
    if(empty($_POST['lesson_id'])) $errors[] = 'Ders seçimi yapmalısınız.';
    if(empty($_POST['title'])) $errors[] = 'Konu başlığı alanı boş bırakılamaz.';

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 300, 'message' => implode('\n', $errors)]);
    } else {
        $title = $db->rescape($_POST['title']);
        $slug = generateSlug($title);

        $data = [
            'lesson_id' => intval($_POST['lesson_id']),
            'title' => $title,
            'slug' => $slug
        ];

        if($db -> insertData('lessons_subjects', $data))
        {
            echo json_encode(['status' => 200, 'message' => 'Konu başarıyla eklendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

if(isset($_POST['edit_subject']))
{
    $errors = [];
    $id = intval($_POST['id']);

    if(empty($_POST['lesson_id'])) $errors[] = 'Ders seçimi yapmalısınız.';
    if(empty($_POST['title'])) $errors[] = 'Konu alanı boş bırakılmaz.';

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 300, 'message' => implode('\n', $errors)]);
    } else {
        $title = $db->rescape($_POST['title']);
        $slug = generateSlug($title);

        $data = [
            'lesson_id' => intval($_POST['lesson_id']),
            'title' => $title,
            'slug' => $slug
        ];

        if($db -> updateData('lessons_subjects', $data, $id))
        {
            echo json_encode(['status' => 200, 'message' => 'Konu başarıyla güncellendi. Yönlendiriliyorsunuz...']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

if(isset($_POST['s_activate']))
{
    $stat = $_POST['s_activate'];
    $id = intval($_POST['id']);

    if($stat == 'true')
    {
        $data = ['is_active' => 1];
        $msg = 'Konu yayına alındı.';
        $cls = 'bg-success';
    }

    if($stat == 'false')
    {
        $data = ['is_active' => 0];
        $msg = 'Konu yayından kaldırıldı.';
        $cls = 'bg-danger';
    }

    if($db -> updateData('lessons_subjects', $data, $id))
    {
        echo json_encode(['status' => 200, 'message' => $msg, 'cls' => $cls]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

if(isset($_POST['delete_subject']))
{
    $id = intval($_POST['id']);
    $data = ['is_delete' => 1];

    if($db -> updateData('lessons_subjects', $data, $id))
    {
        echo json_encode(['status' => 200, 'message' => 'Konu silindi. Yönlendiriliyorsunuz...']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

if(isset($_POST['prep_subject']))
{
    $id = intval($_POST['id']);
    $lesson_id = intval($_POST['lesson_id']);
    $opt = '<option value="">Seçiniz...</option>';
    $q = $db -> q("SELECT * FROM lessons WHERE is_delete = 0 ORDER BY id ASC");

    while($r = $db -> object($q))
    {
        if($r -> id == $lesson_id)
        {
            $opt .= '<option value="'.$r -> id.'" selected>'.$r -> title.'</option>';
        } else {
            $opt .= '<option value="'.$r->id.'">'.$r->title.'</option>';
        }
    }

    $getsubject = $db -> q("SELECT * FROM lessons_subjects WHERE id = {$id} ORDER BY id ASC ");
    $r = $db -> object($getsubject);
    $data = [
        'id' => $r -> id,   
        'lesson_id' => $r -> lesson_id,
        'title' => $r -> title,
        'lessons' => $opt,
        'is_active' => $r -> is_active,
        'is_delete' => $r -> is_delete
    ];

    echo json_encode($data);
}

if(isset($_POST['get_subjects']))
{
    $lesson_id = intval($_POST['id']);
    $opt = '<option value="0">Seçiniz...</option>';
    $q = $db -> q("SELECT * FROM lessons_subjects WHERE lesson_id = {$lesson_id} AND is_delete = 0 ORDER BY id ASC");

    while($r = $db -> object($q))
    {
        $opt .= '<option value="'.$r->id.'">'.$r->title.'</option>';
    }

    echo json_encode($opt);
}

// LESSONS
if(isset($_POST['activate']))
{
    $stat = $_POST['activate'];
    $id = intval($_POST['id']);

    if($stat == 'true')
    {
        $data = ['is_active' => 1];
        $msg = 'Ders yayına alındı.';
        $cls = 'bg-success';
    }

    if($stat == 'false')
    {
        $data = ['is_active' => 0];
        $msg = 'Ders yayından kaldırıldı';
        $cls = 'bg-danger';
    }

    if($db -> updateData('lessons', $data, $id))
    {
        echo json_encode(['status' => 200, 'message' => $msg, 'cls' => $cls]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

if(isset($_POST['delete_lesson']))
{
    $id = intval($_POST['id']);
    $data = ['is_delete' => 1];

    if($db -> updateData('lessons', $data, $id))
    {
        echo json_encode(['status' => 200, 'message' => 'Ders başarıyla silindi. Yönlendiriliyorsunuz...']);
    } else {
        echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
    }
}

if(isset($_POST['edit_lesson']))
{
    $errors = [];
    $id = intval($_POST['lesson_id']);

    if(empty($_POST['lesson_title'])) $errors[] = 'Ders başlığı alanı boş bırakılamaz.';

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 300, 'message' => $errors]);
    } else {
        $data = ['title' => $db -> rescape($_POST['lesson_title'])];

        if($db -> updateData('lessons', $data, $id))
        {
            echo json_encode(['status' => 200, 'message' => 'Ders başlığı başarıyla güncellendi. Yönlendiriliyorsunuz...']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

if(isset($_POST['get_lesson']))
{
    $id = intval($_POST['id']);
    $q = $db -> q("SELECT * FROM lessons WHERE id = {$id} ORDER BY id ASC");

    if($db -> numrows($q) > 0)
    {
        $r = $db -> object($q);

        echo json_encode(['status' => 200, 'id' => $r -> id, 'title' => $r -> title]);
    } else {
        echo json_encode(['status' => 400, 'message' => 'Ders başlığı bulunamadı.']);
    }
}

if(isset($_POST['add_lesson']))
{
    $errors = [];

    if(empty($_POST['lesson_title'])) $errors[] = 'Ders başlığı alanı boş bırakılamaz.';

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 300, 'message' => $errors]);
    } else {
        $data = ['title' => $db -> rescape($_POST['lesson_title'])];

        if ($db -> insertData('lessons', $data))
        {
            echo json_encode(['status' => 200, 'message' => 'Ders eklendi. Yönlendiriliyorsunuz...']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

?>