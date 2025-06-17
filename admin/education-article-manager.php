<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/education/class.articles.php");
require_once("core/class.func.php");

$subjectHash = $_GET['subject'] ?? '';
$art = new EducationArticles();

?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Şehirde Yoga | Konu İçeriği</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">
    <link rel="stylesheet" href="assets/libs/sweetalert2/sweetalert2.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/buttons.dataTables.min.css">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />

    <style>
    #editor-container {
        height: 600px;
        min-height: 600px;
        background-color: #fff;
        border-radius: 0 0 5px 5px;
    }

    .ql-customGallery::before {
        content: '\1F50D';
    }
    </style>

</head>

<body>
    <div id="layout-wrapper">
        <?php
            require_once('layouts/header.php');
            require_once('layouts/leftmenu.php');
        ?>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Konu İçerikleri</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="education-subjects.php">Konular</a></li>
                                        <li class="breadcrumb-item active">İşlemler</li>
                                    </ol>
                                </div>
                            </div>

                            <div class="modal fade zoomIn" id="searcFile" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
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
                                                                if($file != '.' && $file != '..'){
                                                                    //skip folders
                                                                    if(is_dir('../media/gallery/'.$file)) continue;
                                                                    //upload date
                                                                    $date = date('d.m.Y H:i', filemtime('../media/gallery/'.$file));
                                                            ?>
                                                            <tr>
                                                                <td><img src="../media/gallery/<?=$file?>" class="img-fluid" style="width: 50px; height: 50px;"></td>
                                                                <td><?=$file?></td>
                                                                <td><?=$date?></td>
                                                                <td>
                                                                    <a href="../media/gallery/<?=$file?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="İndir" class="btn btn-sm btn-danger btn-icon waves-effect" download><i class="ri-download-2-line"></i></a>
                                                                    <button class="btn btn-primary btn-sm insert_img" data-bs-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Ekle" onclick="insertImage('../media/gallery/<?=$file?>')">Ekle</button>
                                                                </td>
                                                            </tr>
                                                            <?php }}?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="card">
                                <?php
                                //Read Article
                                if(isset($_GET['read-article'])){
                                ?>
                                    <div class="card-body">
                                        <div data-simplebar data-simplebar-auto-hide="false" style="max-height: 660px;" class="px-3">
                                            <?=$art->getArticle()->article?>
                                        </div>                                    
                                    </div>
                                    <div class="card-footer text-end">
                                        <a href="education-article-manager.php?subject=<?=$art->subject?>" class="card-link link-secondary"><i class="ri-arrow-left-s-line ms-1 align-middle lh-1"></i> Geri Dön</a>
                                    </div>   

                                <?php }else{                                   
                                    //Create Add Panel
                                    if(!isset($_GET['art'])){
                                ?>
                                    <div class="card-body">
                                        <p class="card-text mb-4"><b>Konu :</b> <span class="text-muted"><?=$art->subject($subjectHash)->title?></span></p>

                                        <div id="editor-container"></div>

                                        <input type="hidden" name="subject_id" value="<?=$art->subject($subjectHash)->id?>">
                                        <input type="hidden" name="education_id" value="<?=$art->subject($subjectHash)->education_id?>">
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" name="add_art" class="btn btn-primary">Kaydet</button>
                                    </div>

                                <?php 
                                    }else{
                                    //Create Edit Panel
                                ?>
                                    <div class="card-body">
                                        <p class="card-text mb-4">
                                            <b>Konu :</b> <span class="text-muted"><?=$art->subject($subjectHash)->title?></span>
                                        </p>
                                        
                                        <div id="editor-container"></div>
                                        <input type="hidden" name="article_id" value="<?=$art->getArticle()->id?>">

                                        <input type="hidden" name="article_id" value="<?=$art->getArticle()->id?>">
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" name="edit_art" class="btn btn-primary">Güncelle</button>
                                        <a href="education-article-manager.php?subject=<?=$art->subject?>" class="btn btn-danger">Vazgeç</a>
                                    </div>
                                <?php }}?>
                            </div>
                        </div>
                        <div class="col-md-3 h-100">
                            <div data-simplebar data-simplebar-auto-hide="false" style="max-height: 660px;" class="px-3">
                                <?php
                                $subject = $art->subject($subjectHash);
                                if ($subject) {
                                    foreach ($art->getArticles($subject->id, "DESC") as $a) {
                                ?>
                                <div class="card">
                                    <?php
                                    if (preg_match('/<img[^>]+src="([^">]+)"/i', $a->article, $sonuc)) {
                                        //echo "Resim URL'si: " . $sonuc[1];
                                        echo '<img class="card-img-top img-fluid" src="'.$sonuc[1].'">';
                                    }
                                    ?>
                                    
                                    <div class="card-body">
                                        <?=mb_substr($db->stripper($a->article),0,300)?>...
                                    </div>
                                    <div class="card-footer">
                                        <div class="clearfix">
                                            <a href="education-article-manager.php?subject=<?=$art->subject?>&art=<?=md5('zsistem'.$a->id)?>&read-article" class="card-link link-secondary float-start">Devamını oku <i class="ri-arrow-right-s-line ms-1 align-middle lh-1"></i></a>
                                                                                       
                                            
                                            <a data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?=md5('zsistem'.$a->id)?>" href="javascript:;" class="btn btn-sm btn-danger btn-icon waves-effect waves-light me-1 float-end">
                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sil"></i>
                                            </a>

                                            <a href="education-article-manager.php?subject=<?=$art->subject?>&art=<?=md5('zsistem'.$a->id)?>" class="btn btn-sm btn-secondary btn-icon waves-effect waves-light me-1 float-end" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Düzenle">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            
                                        </div>                                        
                                    </div>
                                </div>
                                <?php  
                                   }
                                }
                                ?>
                            </div>

                            <div class="modal fade zoomIn" id="deleteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                        </div>
                                        <div class="modal-body p-5 text-center">
                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                            <div class="mt-4 text-center">
                                                <h4 class="fs-semibold">İçerik silinecek ? Emin misiniz?</h4>
                                                <p class="text-muted fs-14 mb-4 pt-1">Veritabanından tamamen silinir ve geri alınamaz.</p>
                                                <div class="hstack gap-2 justify-content-center remove">
                                                    <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal">
                                                        <i class="ri-close-line me-1 align-middle"></i> Vazgeç
                                                    </button>
                                                    <button class="btn btn-danger" value="" id="delete-record">Anladım, Silebilirsin!</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>

            <?php
                require_once("layouts/footer.php");
            ?>
        </div>
        <!-- end main content-->

    </div>
    
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    
    <script src="assets/js/jquery.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    
    <script src='assets/js/toastify.js'></script>
    <script src='assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
    <script src='assets/libs/flatpickr/flatpickr.min.js'></script>
    
    <script src="assets/js/app.js"></script>
    

    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script src="assets/libs/quill/quill.min.js"></script>
    <script src="assets/libs/quill/quill-resize-image.min.js"></script>
    
    <script>
        const quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link'],
                        ['clean'],
                        ['customGallery']
                    ],
                    handlers: {
                        'customGallery': function () {
                            $('#searcFile').modal('show');
                        }
                    }
                }
            }
        });        

        <?php if(isset($_GET['art'])): ?>
        quill.root.innerHTML = `<?= str_replace(["\r", "\n"], ["", ""], $art->getArticle()->article) ?>`;
        <?php endif; ?>

        function insertImage(src) {
            const range = quill.getSelection();
            if (range) {
                quill.insertEmbed(range.index, 'image', src);
            }
        }
    </script>

    <script>
        $(document).ready(function(){
            $('.delete').click(function(e){
                e.preventDefault();
                var id = $(this).attr('data-bs-whatever');
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Dosya silinecek!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, Sil!',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: 'core/education/api.articles.php',
                            data: {delete_speech : true, audio_id : id},
                            success: function(data) {

                                if(data.status == 200){
                                    Toastify({
                                        text: data.message,
                                        duration: 800,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: 'center',
                                        className: "bg-success",
                                        stopOnFocus: true,
                                    }).showToast();
                                    setInterval(function(){ window.location.href = 'education-article-manager.php?subject=<?= $art->subject ?>&art=<?= $art->article ?>&speech'  }, 900);
                                }
                                if(data.status == 400){
                                    Toastify({
                                        text: data.message,
                                        duration: 800,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: 'center',
                                        className: "bg-danger",
                                        stopOnFocus: true,
                                    }).showToast();
                                }
                            }
                        });
                    }
                });
            });


            $('[role="delete"]').click(function(){
                var id = $(this).attr('id');
                console.log(id);
            });
            $('[name="edit_art"]').click(function(){
                var article = quill.root.innerHTML;
                var article_id = $('[name="article_id"]').val();
                $.ajax({
                    url: 'core/education/api.articles.php',
                    type: 'POST',
                    data: {edit_art : true, article, article_id},
                    success: function(data){
                        if(data.status == 200){
                            Toastify({
                                text: data.message,
                                duration: 2000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                className: "bg-success",
                                stopOnFocus: true,
                            }).showToast();
                            setInterval(function(){ window.location.reload(); }, 2200);
                        }
                        if(data.status == 400){
                            Toastify({
                                text: data.message,
                                duration: 2000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                className: "bg-danger",
                                stopOnFocus: true,
                            }).showToast();
                        }
                    }
                });
            });
           $('[name="add_art"]').click(function(){
                var article = quill.root.innerHTML;
                var subject_id = $('[name="subject_id"]').val();
                var education_id = $('[name="education_id"]').val();

                $.ajax({
                    url: 'core/education/api.articles.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        add_art: true,
                        article,
                        subject_id,
                        education_id
                    },
                    success: function(data){
                        if(data.status == 200){
                            Toastify({
                                text: data.message,
                                duration: 2000,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                className: "bg-success",
                            }).showToast();
                            setTimeout(() => { location.reload(); }, 2200);
                        } else {
                            Toastify({
                                text: data.message,
                                duration: 2000,
                                close: true,
                                gravity: "top",
                                position: 'center',
                                className: "bg-danger",
                            }).showToast();
                        }
                    },
                    error: function(xhr) {
                        console.error("Sunucu hatası:", xhr.responseText);
                        Toastify({
                            text: "Sunucudan geçerli bir yanıt alınamadı.",
                            duration: 3000,
                            className: "bg-danger",
                            gravity: "top",
                            position: "center"
                        }).showToast();
                    }
                });
            });

            $('#delete-record').click(function (e) {
                e.preventDefault();
                var id = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: 'core/education/api.articles.php',
                    data: {del_art : true, id},
                    success: function(data) {
                        if(data.status == 200){
                            $('#deleteModal').modal('hide');                            
                            new Toastify({
                                text: data.message,
                                duration: 2000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                className: "bg-danger",
                                stopOnFocus: true,
                            }).showToast();
                            setInterval(function(){ window.location.href = 'education-article-manager.php?subject=<?=$art->subject?>'; }, 2200);
                        }
                    }
                });
            });
            $(document).on('show.bs.modal','#deleteModal', function (t) {
                var id = t.relatedTarget.getAttribute("data-bs-whatever");
                $('#delete-record').val(id);
            });
            $('#table-img').DataTable({
                "paging":   true,
                "searching": true,
                "lengthChange": false,
                language: {
                    url: 'assets/json/tr.json',
                },
                "pageLength": 5,
                "info":     false,
            });

            $('#audio-list').DataTable({
                "paging":   true,
                "searching": false,
                "lengthChange": false,
                language: {
                    url: 'assets/json/tr.json',
                },
            });
        });
    </script>
</body>
</html>