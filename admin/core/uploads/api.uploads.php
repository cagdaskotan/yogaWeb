<?php
$uploadDir = '../../../media/gallery/';
header('Content-Type: application/json');

if(isset($_FILES['file'])){
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg','png');
    //upload
    if(in_array($fileActualExt,$allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = time().".".$fileActualExt;
                $fileDestination = $uploadDir.$fileNameNew;
                move_uploaded_file($fileTmpName,$fileDestination);
                echo "Dosya yüklendi: " . $fileName . "<br>";
            }else{
                echo "Dosya boyutu çok büyük.";
            }
        }else{
            echo "Dosya yüklenirken hata oluştu.";
        }
    }else{
        echo "Bu türde dosya yüklenemez.";
    }

}
if(isset($_POST['delete'])){

    $file = $_POST['target'];
    $file = $uploadDir.$file;

    if(file_exists($file)){
        unlink($file);
        echo json_encode(
            array(
                'status' => 200,
                'message' => 'Dosya başarıyla silindi.'
            )
        );
    }else{
        echo json_encode(
            array(
                'status' => 300,
                'message' => 'Dosya bulunamadı.'
            )
        );
    }
}