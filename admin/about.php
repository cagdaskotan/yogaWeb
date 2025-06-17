<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/about/class.about.php");
require_once("core/class.func.php");

$about = new About();
$data = $about->get();
?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Şehirde Yoga | Hakkımızda İçeriği</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <link rel="stylesheet" href="assets/libs/quill/quill.core.css" />
    <link rel="stylesheet" href="assets/libs/quill/quill.snow.css" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/icons.min.css" rel="stylesheet" />
    <link href="assets/css/app.min.css" rel="stylesheet" />
    <link href="assets/css/custom.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/js/toastify.css" />

    <style>
        #editor-container {
            height: 600px;
            background-color: #fff;
            border-radius: 5px;
        }

        .ql-customGallery::before {
            content: '\1F50D'; /* büyüteç simgesi */
        }
    </style>
</head>
<body>
<div id="layout-wrapper">
    <?php require_once('layouts/header.php'); require_once('layouts/leftmenu.php'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="modal fade zoomIn" id="searcFile" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-img" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Resim</th>
                                    <th>İsim</th>
                                    <th>Yükleme Tarihi</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $files = scandir('../media/gallery');
                                foreach($files as $file){
                                    if($file != '.' && $file != '..' && !is_dir('../media/gallery/'.$file)){
                                        $date = date('d.m.Y H:i', filemtime('../media/gallery/'.$file));
                                        echo "<tr>
                                            <td><img src='../media/gallery/{$file}' class='img-fluid' style='width: 50px; height: 50px;'></td>
                                            <td>{$file}</td>
                                            <td>{$date}</td>
                                            <td>
                                                <button class='btn btn-primary btn-sm' onclick=\"insertImage('../media/gallery/{$file}')\">Ekle</button>
                                            </td>
                                        </tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Hakkımızda</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- SOL TARAF -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div id="editor-container"></div>
                            </div>
                        </div>
                    </div>
                    <!-- SAĞ TARAF -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Başlık</label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($data->title) ?>">
                                </div>
                                <button class="btn btn-primary w-100" id="save-about">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php require_once("layouts/footer.php"); ?>
    </div>
</div>

<!-- JS -->
<script src="assets/js/jquery.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/libs/quill/quill.min.js"></script>
<script src="assets/js/toastify.js"></script>

<script>
const quill = new Quill('#editor-container', {
    theme: 'snow',
    modules: {
        toolbar: {
            container: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link'],
                ['clean'],
                ['customGallery'] // buton tanımı
            ],
            handlers: {
                'customGallery': function () {
                    $('#searcFile').modal('show'); // modalı aç
                }
            }
        }
    }
});
function insertImage(src) {
    const range = quill.getSelection();
    if (range) {
        quill.insertEmbed(range.index, 'image', src);
        $('#searcFile').modal('hide');
    }
}

    // Editöre mevcut veriyi yaz
    quill.root.innerHTML = `<?= addslashes($data->article) ?>`;

    $('#save-about').click(function () {
        const content = quill.root.innerHTML;
        const title = $('#title').val().trim();

        if (title === '' || content === '') {
            Toastify({
                text: "Başlık ve içerik boş olamaz.",
                duration: 2500,
                className: "bg-danger",
                gravity: "top",
                position: "center"
            }).showToast();
            return;
        }

        $.ajax({
            url: 'core/about/api.about.php',
            type: 'POST',
            dataType: 'json',
            data: {
                update_about: true,
                title: title,
                article: content
            },
            success: function (data) {
                Toastify({
                    text: data.message,
                    duration: 2500,
                    className: data.status == 200 ? "bg-success" : "bg-danger",
                    gravity: "top",
                    position: "center",
                    close: true
                }).showToast();
            }
        });
    });
</script>
</body>
</html>
