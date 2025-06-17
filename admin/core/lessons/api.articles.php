<?php
ob_start();
session_save_path("../../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
header('Content-Type: application/json');

require_once("../../../env/class.db.php");
require_once("../users/class.users.php");
require_once("../class.func.php");


if(isset($_POST['del_art']))
{
    $errors = array();
    $id = $db -> rescape($_POST['id']);

    if($id == '')
    {
        $errors[] = 'İçerik bilgisi bulunamadı.';
    }

    if(empty($errors))
    {
        $q = $db -> q("DELETE FROM lessons_articles WHERE MD5(concat('zsistem', id)) = '{$id}'");

        if($q)
        {
            echo json_encode(['status' => 200, 'message' => 'Konu içeriği başarıyla silindi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    } else {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    }
}

if(isset($_POST['edit_art']))
{
    $errors = array();

    if($_POST['article'] == '')
    {
        $errors[] = 'Konu içeriği boş olamaz.';
    }

    if(intval($_POST['article_id']) == 0)
    {
        $errors[] = 'İçerik bulunamadı';
    }

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $original = $_POST['article'];
        $stripped = $db -> stripper($original);
        $id = intval($_POST['article_id']);
        $data = ['article' => $db -> rescape($original)];

        if($db -> updateData('lessons_articles', $data, $id))
        {
            echo json_encode(['status' => 200, 'message' => 'Konu içeriği başarıyla güncellendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

if(isset($_POST['add_art']))
{
    $errors = [];
    
    if($_POST['article'] == '')
    {
        $errors[] = 'Konu içeriği boş olamaz.';
    }

    if(intval($_POST['lesson_id']) == 0)
    {
        $errors[] = 'Ders bilgisi bulunamadı.';
    }

    if(intval($_POST['subject_id']) == 0)
    {
        $errors[] = 'Konu bilgisi bulunamadı.';
    }

    if(count($errors) > 0)
    {
        echo json_encode(['status' => 400, 'message' => implode('*', $errors)]);
    } else {
        $original = $_POST['article'];
        $stripped = $db -> stripper($original);
        $data = [
            'lesson_id' => intval($_POST['lesson_id']),
            'subject_id' => intval($_POST['subject_id']),
            'article' => $db -> rescape($original),
            'is_active' => 0
        ];

        if($db -> insertData('lessons_articles', $data))
        {
            echo json_encode(['status' => 200, 'message' => 'Konu içeriği başarıyla eklendi.']);
        } else {
            echo json_encode(['status' => 400, 'message' => 'İşlem sırasında bir hata oluştu.']);
        }
    }
}

?>